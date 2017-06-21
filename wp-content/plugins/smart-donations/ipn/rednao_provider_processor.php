<?php

function RedNaoAddMessage($message)
{
	global $rednaolog;
	$rednaolog .= $message . "<br/>";
}

class rednao_provider_processor
{

	/** @var  connection_provider_base */
	private $provider;
	/**
	 * @var smart_donations_db_privider
	 */
	private $dbProvider;


	function __construct(rednao_provider_base $provider)
	{
		$this->provider = $provider;
		$this->dbProvider = new smart_donations_db_privider();
	}

	public function ProcessCall()
	{
		global $wpdb;
		RedNaoAddMessage("Latest error:" . $wpdb->last_error);
		RedNaoAddMessage("Checking if it is valid");
		if ($this->provider->IsValid()) {
			RedNaoAddMessage("Request is valid");
			$receiverEmail = $this->provider->GetDonorEmail();
			$properties=array();

			RedNaoAddMessage("Check if it is a donation or refund");
			if ($this->provider->DonationWasReceived()) {
				RedNaoAddMessage("It is a donation");

				$formId = "";
				$sFormId = "";
				$type = "sd";
				$additionalData=null;

				$this->ProcessCustomField($properties, $formId, $sFormId, $type,$additionalData);
				$properties['status'] = 'c';
				if (($type == "sd" && $this->provider->ReceiverIsValid($receiverEmail)) || ($type == "sf" && SmartFormsEmailIsValid($receiverEmail))) {
					RedNaoAddMessage("Inserting transaction");
					if ($this->dbProvider->TransactionIsRepeated($properties))
						return false;

					$this->ProcessValidPayPalRequest($properties, $formId, $sFormId, $type,$additionalData);
					delete_transient($formId);
					delete_option($formId);
				}else
				{
					delete_transient($formId);
					delete_option($formId);
					return false;
				}
			}


			if ($this->DonationWasRefunded()) {
				RedNaoAddMessage("Is a refund");
				if (isset($_POST['parent_txn_id'])) {
					RedNaoAddMessage("Refunding transaction in the database");
					$this->dbProvider->RefundTransaction($this->provider->GetTransactionId());
				}

			}

			if ($this->provider->GetCampaignId()) {
				$campaign_id = $this->provider->GetCampaignId();
				global $wpdb;
				$result = $wpdb->get_results($wpdb->prepare("select progress_id from " . SMART_DONATIONS_PROGRESS_TABLE . " where campaign_id=%d", $campaign_id));
				foreach ($result as $key => $value) {
					delete_transient("rednao_smart_donations_progress_$value->progress_id");
				}
				delete_transient("rednao_smart_donations_wall_" . $campaign_id);
			}
			$this->SendLogIfNeeded();
			return true;

		} else {
			RedNaoAddMessage("Transaction is not valid");
			$this->SendLogIfNeeded();
			return false;
		}

	}

	private function ProcessCustomField(&$properties, &$formId, &$sFormId, &$type,&$additionalData)
	{
		$additionalData=array();
		$properties=$this->provider->GetProperties();
		if (!is_numeric($properties['campaign_id'])) {
			RedNaoAddMessage("Is a form");
			$formString = rawurldecode($properties['campaign_id']);
			parse_str($formString, $formStringParameters);
			if (sizeof($formStringParameters) == 2 || sizeof($formStringParameters) == 4) {
				$properties['campaign_id'] = $formStringParameters['campaign_id'];
				$formId = $formStringParameters['formId'];
				$form = get_transient($formId);
				if($form===false)
					$form=get_option($formId);
				$splittedFormOptions = explode('rednaosplitter', $form);
				if(count($splittedFormOptions)==3)
					$additionalData=json_decode($splittedFormOptions[2],true);

				if (isset($formStringParameters['type']) && $formStringParameters['type'] == 'form') {
					$type = 'sf';
					$sFormId = $formStringParameters['sformid'];
					require_once SMART_FORMS_DIR . "integration/smart-donations-integration-ipn.php";
				}
			} else {
				RedNaoAddMessage("Is not a form");
				$this->SendFormError($properties['payer_email'], 'the parameters sent by paypal are corrupt', $properties);
				return;
			}
		}
	}




	private function SendFormError($error, $properties)
	{
		global $rednaolog;
		RedNaoAddMessage($error);
	}



	private  function ProcessValidPayPalRequest(&$properties, $formId, $sFormId, $type,$additionalData)
	{
		$sendThankYouEmailAndForm="";
		$referenceId=0;
		$this->InitializeValidPayPalRequestVariables($properties,$sendThankYouEmailAndForm,$referenceId,$formId);

		$properties["is_anonymous"]=(!isset($additionalData['anonymousDonation'])||$additionalData['anonymousDonation']=="n")?0:1;
		RedNaoAddMessage("Inserting transaction");
		if ($this->dbProvider->InsertTransaction($properties)) {
			RedNaoAddMessage("Transaction was inserted sucessfully");

		}

		global $wpdb;
		RedNaoAddMessage("Latest error:" . $wpdb->last_error);

		if (!$sendThankYouEmailAndForm)
			return;

		$this->ProcessThankYouEmailIfAny($properties);
		if ($formId != null) {
			$this->ProcessForm($properties, $formId, $type, $properties['reference_id'], $sFormId);
		}


	}

	private function InitializeValidPayPalRequestVariables(&$properties,&$sendThankYouEmailAndForm,&$referenceId,$formId)
	{
		$txn_type = $this->provider->GetTransactionType();


		if ($properties['subscr_id'] == "")
			$referenceId = $properties['txn_id'];
		else
			$referenceId = $properties['subscr_id'];
		$properties['reference_id'] = $referenceId;

		$sendThankYouEmailAndForm = $txn_type != 'subscr_payment' || !$this->dbProvider->SubscriptionAlreadyExists($properties);

		$form = "";
		if ($formId != null)
		{
			$form = get_transient($formId);
			if($form===false)
				$form=get_option($formId);
		}

		$properties['form_information'] = $form ? $form : "";
	}

	private function ProcessThankYouEmailIfAny($properties)
	{
		RedNaoAddMessage("Processing thank you email");
		$campaign_id = $properties['campaign_id'];
		if ($campaign_id > 0) {
			global $wpdb;
			$results = $wpdb->get_results($wpdb->prepare("SELECT email_subject,email_from,thank_you_email FROM " . SMART_DONATIONS_CAMPAIGN_TABLE . " where campaign_id=%d", $campaign_id));

			if (count($results) > 0) {
				$result = $results[0];
				if ($result->email_subject != null) {
					try {
						$headers = 'MIME-Version: 1.0' . "\r\n";
						$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
						if ($result->email_from != '')
							$headers .= 'From: ' . $result->email_from . ' <' . $result->email_from . '>' . "\r\n";
						wp_mail($_POST['payer_email'], $result->email_subject, $result->thank_you_email, $headers);
					} catch (Exception $e) {
						$this->SendFormError($e->getMessage(), $properties);
					}
				}
			}
		}

	}

	private function ProcessForm($properties, $formId, $formType, $referenceId, $sFormId)
	{
		$form = get_transient($formId);
		if($form===false)
			$form=get_option($formId);
		RedNaoAddMessage("Processing form");

		$splittedFormOptions = explode('rednaosplitter', $form);
		if ($form == false) {
			$this->SendFormError('The submitted form was not found, that means this transaction was processed 3 days after the payment', $properties);
			return;
		}

		if ($formType == 'sf') {

			SmartFormsSaveDonationForm($sFormId, $splittedFormOptions[1], $referenceId);
			return;
		}

		$formElementsValues = explode('&', $splittedFormOptions[1]);

		try {
			$this->SendFormEmail($formElementsValues, $properties, $splittedFormOptions[0]);

		} catch (Exception $e) {
			$this->SendFormError($e->getMessage(), $properties);
		}


	}

	private function SendFormEmail($formElementsValues, $properties, $notifyToEmails)
	{
		$email = '<table border="1" cellspacing="1">';

		$email .= "<tr><td style='padding:10px'><b>Donor</b></td><td style='padding:10px'>" . $properties['payer_email'] . "</td></tr>";

		foreach ($formElementsValues as $value) {
			$splitValue = explode('=', $value);

			$label = rawurldecode($splitValue[0]);
			$email .= "<tr><td style='padding:10px'><b>" . htmlentities($label) . "</b></td>";
			if (sizeof($splitValue) == 2) {
				$value = explode(',', $splitValue[1]);


				if (sizeof($value) >= 2) {
					$email .= "<td><table>";
					for ($i = 0; $i < sizeof($value); $i++) {
						$email .= "<tr><td style='padding:10px'>" . htmlentities(rawurldecode($value[$i])) . "</td></tr>";
					}
					$email .= "</table></td>";
				} else
					$email .= "<td style='padding:10px'>" . htmlentities(rawurldecode($value[0])) . "</td>";
			}

			$email .= "</tr>";
		}

		$email .= "</table>";
		try {
			global $wpdb;
			$emailFrom = $wpdb->get_var($wpdb->prepare("SELECT email_from FROM " . SMART_DONATIONS_CAMPAIGN_TABLE . " where campaign_id=%d", $properties['campaign_id']));


			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			if ($emailFrom != '')
				$headers .= 'From: ' . $emailFrom . ' <' . $emailFrom . '>' . "\r\n";

			if ($notifyToEmails != null) {
				$notifyEmail = str_replace(';', ',', $notifyToEmails);
			} else
				$notifyEmail = $_POST['business'];
			wp_mail($notifyEmail, 'Donation Received', $email, $headers);
		} catch (Exception $e) {
			$this->SendFormError($e->getMessage(), $properties);
		}
	}

	private function DonationWasRefunded()
	{
		if (isset($_POST['payment_status'])) {
			$status = strtolower($_POST['payment_status']);
			return $status === "refunded" || $status == "denied" || $status == "expired" || $status == "failed" || $status == "reversed" || $status == "voided";
		}
		return false;
	}

	public function SendLogIfNeeded()
	{
		if (get_option('smartDonationsEnableDebug') == 'y') {
			global $rednaolog;
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			wp_mail(get_option('smartDonationsSendToLog'), 'Log', $rednaolog, $headers);
			update_option('smart_donations_latest_error', $rednaolog);

		}
	}

}