<?php
/**
 * Created by JetBrains PhpStorm.
 * User: edseventeen
 * Date: 5/18/13
 * Time: 6:57 PM
 * To change this template use File | Settings | File Templates.
 */



class smart_donations_db_privider {
    private $_TransactionIsRepeated=NULL;

    public function InsertTransaction($properties)
    {
		$donationId=0;
        if($this->TransactionIsRepeated($properties))
            return false;
        $this->SanitizeProperties($properties);
        $this->InsertIntoDatabase($properties);
        return true;
    }

    public function TransactionIsRepeated($properties)
    {
		RedNaoAddMessage("Checking if transaction is repeated");
        if($this->_TransactionIsRepeated===NULL)
        {
            global $wpdb;
			$query=$wpdb->prepare("select count(*) from ".SMART_DONATIONS_TRANSACTION_TABLE." where txn_id=%s",$properties['txn_id']);
			$this->_TransactionIsRepeated=($wpdb->get_var($query)>0);
        }
        return $this->_TransactionIsRepeated;
    }

	public function SubscriptionAlreadyExists($properties)
	{
		global $wpdb;
		return $wpdb->get_var($wpdb->prepare("select count(*) from ".SMART_DONATIONS_TRANSACTION_TABLE." where subscr_id=%s ",$properties['subscr_id']))>0;
	}

    private function InsertIntoDatabase($properties)
    {
		if($properties['subscr_id']!="")
		{
			if($this->RecurrentDonationWasAnonymous($properties))
				$properties['is_anonymous']=1;

		}
        global $wpdb;
        $wpdb->insert(SMART_DONATIONS_TRANSACTION_TABLE,$properties);
		return $wpdb->insert_id;
    }

	private  function RecurrentDonationWasAnonymous($properties)
	{
		global $wpdb;
		$isAnonymous= $wpdb->get_var($wpdb->prepare("select count(*) from ".SMART_DONATIONS_TRANSACTION_TABLE." where subscr_id=%s and is_anonymous=1 ",$properties['subscr_id']))>0;
		return $isAnonymous;
	}

    private function SanitizeProperties(& $properties)
    {
        $properties['date'] = date('Y-m-d H:i:s', strtotime($properties['date']));

        if($properties['mc_fee']==null)
            $properties['mc_fee']=0;

        if($properties['mc_gross']==null)
            $properties['mc_gross']=0;

        if($properties['additional_fields']==null)
            $properties['additional_fields']='';

        if($properties['campaign_id']==null)
            $properties['campaign_id']=0;
    }

    public function RefundTransaction($txn_id)
    {
        global $wpdb;
        $wpdb->query($wpdb->prepare("delete from ".SMART_DONATIONS_TRANSACTION_TABLE." WHERE txn_id=%s",$txn_id));




    }


}