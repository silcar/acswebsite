
//<editor-fold desc="Base Donaiton Provider">
function smartDonationsBaseDonationProvider(){
    this.Amount=0;
    this.Id='';
}

smartDonationsBaseDonationProvider.prototype.GetStartOfDonationForm=function(){};
smartDonationsBaseDonationProvider.prototype.GetEndOfDonationForm=function(){};
//</editor-fold>




//<editor-fold desc="PayPal">
function smartDonationsPayPalProvider(){
    smartDonationsBaseDonationProvider.call(this);
    this.Id='paypal';
}

smartDonationsPayPalProvider.prototype=Object.create(smartDonationsBaseDonationProvider.prototype);

smartDonationsPayPalProvider.prototype.GetStartOfDonationForm=function(generator,defaultQuantity)
{
    var payPalUrl='';
    if(smartDonationsSandbox=='y')
        payPalUrl='https://www.sandbox.paypal.com/cgi-bin/webscr';
    else
        payPalUrl='https://www.paypal.com/cgi-bin/webscr';

    var itemName="Donation"
    if(typeof generator.donation_description!='undefined')
        itemName=generator.donation_description;

    var donationText= '<div class="smartDonationsDonationGeneratedItem"  >\
                <form action="'+payPalUrl+'" method="post" class="donationForm" target="_blank">      \
                <input type="hidden" name="cmd" class="smartDonationsPaypalCommand" value="_donations">\
                <input type="hidden" name="item_name" value="'+itemName+'">\
                <input type="hidden" name="business" value="'+generator.business+'">\
                <input type="hidden" name="lc" value="'+generator.selectedCountry+'">                       \
                <input type="hidden" name="no_note" value="0">                    \
                <input type="hidden" name="currency_code" value="'+generator.donation_currency+'">             \
                <input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">\
                <input name="bn" value="Rednao_SP" type="hidden">\
                <input type="hidden" name="custom" value="'+generator.campaign_id+'">';

    if(typeof smartDonationsRootPath != 'undefined')
        donationText+='<input type="hidden" name="notify_url" value="'+smartDonationsIPNUrl+'">';

    if(generator.returningUrl)
        donationText+='<input type="hidden" name="return" value="'+generator.returningUrl+'">';

    var quantity=-1;

    try{
        quantity=parseFloat(defaultQuantity);
    }catch(exception)
    {

    }

    if(!isNaN(quantity))
        donationText+='<input type="hidden" name="amount" class="amountToDonate" value="'+defaultQuantity+'">';

    return donationText;


};

smartDonationsPayPalProvider.prototype.GetButton=function(imageToUse)
{
    return '<input type="image" class="smartDonationsDonationButton smartDonationsEditableItem" src="'+imageToUse+'" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"><img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">';
};

smartDonationsPayPalProvider.prototype.GetEndOfDonationForm=function()
{
    return '</form>\
             </div>';
};
//</editor-fold>

smartDonationsPayPalProvider.prototype.SetAmount=function(amount)
{

};



smartDonationsPayPalProvider.prototype.Submit=function(jQueryForm)
{
    return true;
};

smartDonationsPayPalProvider.prototype.FormSubmissionCompleted=function(data,generator,amount)
{
    if(data.status=="success")
    {
        var form=generator.GetRootContainer().find('form');
        form.attr('target','_self');
        form.find('input[name=custom]').val(encodeURI('campaign_id='+generator.campaign_id+"&formId="+data.randomString))
        if(amount>0)
            form.append('<input type="hidden" name="amount" class="amountToDonate" value="'+amount+'">');

        if(generator.IsRecurrentPayment(form))
        {
            if(amount<=0)
            {
                alert('Please set a donation amount before proceeding');
                return;
            }
            generator.TurnFormIntoRecurrentPayment(form);
        }

        form.submit();


    }else
    {
        alert("An error occured, please try again");
    }

};





RedNaoEventManager.Subscribe('GetProvider',function(arg)
{
    if(arg.donation_provider=='paypal')
        arg.provider=new smartDonationsPayPalProvider();
})
//</editor-fold>




