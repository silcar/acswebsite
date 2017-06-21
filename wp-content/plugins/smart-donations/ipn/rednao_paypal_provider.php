<?php
require_once "rednao_provider_base.php";
class rednao_paypal_provider extends   rednao_provider_base{

	private $properties=Array();
	function __construct()
	{
		$this->GetPropertiesArray();
	}

	private function GetPropertiesArray()
	{
		if (isset($_POST['txn_id'])) {
			$this->properties['txn_id'] = $_POST['txn_id'];
		} else
			$this->properties['txn_id'] = '';


		if (isset($_POST['payer_email'])) {
			$this->properties['payer_email'] = $_POST['payer_email'];
		} else
			$this->properties['payer_email'] = '';


		if (isset($_POST['first_name'])) {
			$this->properties['first_name'] = $_POST['first_name'];
		} else
			$this->properties['first_name'] = '';


		if (isset($_POST['last_name'])) {
			$this->properties['last_name'] = $_POST['last_name'];
		} else
			$this->properties['last_name'] = '';

		if (isset($_POST['mc_fee'])) {
			$this->properties['mc_fee'] = $_POST['mc_fee'];
		} else
			$this->properties['mc_fee'] = '';

		if (isset($_POST["subscr_id"]))
			$this->properties['subscr_id'] = $_POST['subscr_id'];
		else
			$this->properties['subscr_id'] = '';

		if (isset($_POST['mc_gross'])) {
			$this->properties['mc_gross'] = $_POST['mc_gross'];
		} else
			$this->properties['mc_gross'] = '';


		if (isset($_POST['payment_date'])) {
			$this->properties['date'] = $_POST['payment_date'];
		} else
			$this->properties['date'] = '';


		if (isset($_POST['additional_fields'])) {
			$this->properties['additional_fields'] = $_POST['additional_fields'];
		} else
			$this->properties['additional_fields'] = '';


		if (isset($_POST['custom'])) {
			$this->properties['campaign_id'] = $_POST['custom'];
		} else
			$this->properties['campaign_id'] = '';

	}




	public function GetDonorEmail()
	{
		if (isset($_POST["receiver_email"])) {
			return $_POST["receiver_email"];
		} else
			return '';
	}

	public function DonationWasReceived()
	{
		$txn_type = '';
		if (isset($_POST['txn_type']))
			$txn_type = $_POST['txn_type'];

		if (isset($_POST['payment_status'])) {
			return $_POST['payment_status'] === "Pending" || $_POST['payment_status'] == "Completed" || $txn_type == "subscr_payment";
		}
		return false;
	}

	public function IsValid()
	{
		if(get_option('rednao_skippaypal')=='y')
			return true;

		$raw_post_data = file_get_contents('php://input');
		$raw_post_array = explode('&', $raw_post_data);
		$myPost = array();
		foreach ($raw_post_array as $keyval)
		{
			$keyval = explode ('=', $keyval);
			if (count($keyval) == 2)
				$myPost[$keyval[0]] = urldecode($keyval[1]);
		}
		// read the post from PayPal system and add 'cmd'

		$args=Array();
		// $args['cmd']="_notify-validate'";

		$args['headers']=Array
		(
			'Content-Type'=>'application/x-www-form-urlencoded;',
			'Method'=>'Post'
		);

		$req = "cmd=_notify-validate";
		$args['body']=array('cmd'=>"_notify-validate");
		if(function_exists('get_magic_quotes_gpc'))
		{
			$get_magic_quotes_exists = true;
		}
		foreach ($myPost as $key => $value)
		{
			if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1)
			{
				$args['body'][$key]=stripslashes($value);
				$value = urlencode(stripslashes($value));
			} else
			{
				$args['body'][$key]=$value;
				$value = urlencode($value);
			}
			$req .= "&$key=$value";
		}


		// STEP 2: Post IPN data back to paypal to validate
		$url="https://www.paypal.com/cgi-bin/webscr";

		if(SMART_DONATIONS_SANDBOX=="y")
			$url="https://www.sandbox.paypal.com/cgi-bin/webscr";
		$res=wp_remote_post($url,$args);

		global $rednaolog;
		$rednaolog.="Payal response:".$res['body']."<br/>";;

		return strcmp ($res['body'], "VERIFIED") == 0;


	}

	public function GetProperties()
	{
		return $this->properties;
	}

	public function GetTransactionId()
	{
		return $_POST['parent_txn_id'];
	}

	public function GetCampaignId()
	{
		return $this->properties['campaign_id'];
	}

	public function GetTransactionType()
	{
		return $_POST['txn_type'];
	}

	public function ReceiverIsValid($receiverEmail)
	{
		RedNaoAddMessage($receiverEmail);
		global $wpdb;
		$count = $wpdb->get_var($wpdb->prepare("select count(*) from " . SMART_DONATIONS_TABLE_NAME . " where email=%s", $_POST["receiver_email"]));

		if($count<=0)
			$count=$wpdb->get_var($wpdb->prepare("select count(*) from " . SMART_DONATIONS_TABLE_NAME . " where email=%s", $_POST["business"]));
		return $count > 0;
	}

}

