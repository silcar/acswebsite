<?php

abstract class rednao_provider_base {
	public abstract function IsValid();
	public abstract function GetDonorEmail();
	public abstract function DonationWasReceived();
	public abstract function GetTransactionId();
	public abstract function GetCampaignId();
	public abstract function GetTransactionType();
	public abstract function GetProperties();
	public abstract function ReceiverIsValid($receiverEmail);
} 