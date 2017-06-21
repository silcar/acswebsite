

var donationTypeSelected;
function SmartDonationSettings()
{
    rnJQuery('#smartDonationsAdvancedDetail').hide();
    rnJQuery('#smartDonationsBasic').click(SmartDonations_tagClicked);
    rnJQuery('#smartDonationsAdvanced').click(SmartDonations_tagClicked);
    rnJQuery('.smartDonationsItem').click(function(){SmartDonations_donationTypeClicked(this)});
    rnJQuery('#smartDonationsBackFromConfiguration').click(SmartDonations_backFromConfiguration);

    var configurationOptions=rnJQuery("#smartDonationsItemsList");
    var configurationSettings=rnJQuery("#smartDonationsConfiguration");


    var top = configurationOptions.offset().top-configurationSettings.offset().top;
    var left = configurationOptions.offset().left-configurationSettings.offset().left;

    left+=configurationOptions.width()+2;
    configurationSettings.css("top", top);
    configurationSettings.css("left", left);



}

function SmartDonations_backFromConfiguration() {
    rnJQuery("#smartDonationsSlideAnimation").animate({"left":"0"},250/*,function(){rnJQuery("#smartDonationsSlideAnimation").hide();}*/);
    rnJQuery('#smartdonationsItemsContainer').width(702);
    rnJQuery('#smartdonationsItemsContainer').height(500);
    rnJQuery('#smartDonationsItemsContainerBody').css('overflow-y','hidden');
    rnJQuery('#smartDonationsPreviewContainer').parent().css('display','block');
    RedNaoHiddeMessage();
}


function SmartDonations_donationTypeClicked(div,donationOptions) {

    rnJQuery('#smartDonationsPreviewContainer').css('margin-top','20px');
    if(donationOptions)
    {
        var donationTypeSelected= donationOptions.smartDonationsType;
        donationOptions.isNew=false;
    }else
    {
        donationOptions={};
        donationOptions.isNew=true;
        donationOptions.donation_currency=rnJQuery("#smartDonationsCurrency").val();
        donationOptions.donation_description=rnJQuery('#smartDonationsDescription').val();
        donationOptions.selectedCountry=rnJQuery('#smartDonationsCountry').val();
        donationOptions.donation_provider=rnJQuery("#smartDonationsProvider").val();
        var donationTypeSelected= rnJQuery(div).find(':hidden').val();
    }

    rnJQuery("#smartDonationsType").val(donationTypeSelected);
    SmartDonations_SetSmartDonationConfiguration(this,div,donationTypeSelected,donationOptions);

    //rnJQuery("#smartDonationsSlideAnimation").animate({"left":"-703px"},250/*,function(){rnJQuery("#smartDonationsSlideAnimation").hide();}*/);

}

function SmartDonations_GetDonationTypeSelected(donationTypeSelected,donationProvider,donationOptions)
{

            if(donationTypeSelected=='classic')
                return new smartDonationClassicConfiguration('smartDonationsPreviewContainer',donationOptions);
            if(donationTypeSelected=='textbox')
            {
                rnJQuery('#smartDonationsPreviewContainer').css('margin-top','-10px');
                return new smartDonationTextBoxConfiguration('smartDonationsPreviewContainer',donationOptions);
            }
            if(donationTypeSelected=="threeButtons")
                return new smartDonationsThreeButtonsConfiguration('smartDonationsPreviewContainer',donationOptions);
            if(donationTypeSelected=="slider")
            {
                rnJQuery('#smartDonationsPreviewContainer').css('margin-top','-10px');
                return new smartDonationsSliderConfiguration('smartDonationsPreviewContainer',donationOptions);

            }

            if(donationTypeSelected=="forms")
            {

                rnJQuery('#smartDonationsPreviewContainer').parent().css('display','none');
                rnJQuery('#smartdonationsItemsContainer').width(1200);
                rnJQuery('#smartdonationsItemsContainer').height(800);
                rnJQuery('#smartDonationsItemsContainerBody').css('overflow-y','visible');
                if(!smartFormsIsActive)
                    RedNaoShowMessage("If you want to extend the power of the forms check out the free version of <a href='http://wordpress.org/plugins/smart-forms/' target='_blank' style='color:red; text-decoration: underline;'> Smart Forms!!</a> 100% compatible with Smart Donations");
                return new smartDonationsFormConfiguration('smartDonationsPreviewContainer',donationOptions);

            }

}

function SmartDonations_SetSmartDonationConfiguration(rthis,div,donationTypeSelected,donationOptions)
{
    var business=rnJQuery('#smartDonationsEmail').val();
    var donationProvider=rnJQuery('#rednao_smart_donations_provider').val();



    smartDonationsDonationType=SmartDonations_GetDonationTypeSelected(donationTypeSelected,donationProvider,donationOptions);
    smartDonationsDonationType.generator.business=rnJQuery('#smartDonationsEmail').val();
    smartDonationsDonationType.generator.returningUrl=rnJQuery('#smartDonationsReturningUrl').val();

    smartDonationsDonationType.fillConfiguration();
    smartDonationsDonationType.generator.GenerateDonationItem();

    rnJQuery("#smartDonationsSlideAnimation").animate({"left":"-703px"},250/*,function(){rnJQuery("#smartDonationsSlideAnimation").hide();}*/);



    if(donationOptions)
        SmartDonationsFillConfiguration(donationOptions);


}

function SmartDonationsFillConfiguration(donationOptions)
{
    for(var donationVariable in donationOptions)
    {
        var element=rnJQuery('input[name="'+donationVariable+'"],select[name="'+donationVariable+'"]');

        if(element.is(':checkbox'))
        {
            if(donationOptions[donationVariable]=="on")
                element.attr("checked",'on');
            else
                element.removeAttr("checked");
        }else
            element.val(donationOptions[donationVariable]);
        element.change();
    }
}

function SmartDonations_tagClicked() {
    var src=rnJQuery(this).find('img').attr("src");
    if(src==smartDonations_arrow_closed)
        SmartDonations_openTag(this);
    else
        SmartDonations_closeTag(this);

}

function SmartDonations_closeTag(tag) {
    rnJQuery(tag).find('img').attr("src",smartDonations_arrow_closed)


    var detailName=rnJQuery(tag).attr('id')+'Detail';
    rnJQuery('#'+detailName).slideUp(200);
}


function SmartDonations_openTag(tag) {
    rnJQuery(tag).find('img').attr("src",smartDonations_arrow_open)

    var detailName=rnJQuery(tag).attr('id')+'Detail';
    rnJQuery('#'+detailName).slideDown(200);

}



