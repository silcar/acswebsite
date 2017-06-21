var smartDonationsEditCampaign;

rnJQuery(function()
{
    var notifications=rnJQuery('#rnNotification').RDNotifications();
/*    var smartDonationsCampaignDialog=rnJQuery('#smart-donations-add-new-campaign-panel').dialog({
        modal:true,
        autoOpen:false,
        width:'530px',
        create: function(event, ui){
            rnJQuery('.ui-dialog').wrap('<div class="smartDonationsSlider" />');
        },
        open: function(event, ui){
            rnJQuery('.ui-widget-overlay').wrap('<div class="smartDonationsSlider" />');
            rnJQuery(".smartDonationsConfigurationFields").val('');
        }

    });
*/

    rnJQuery("#sDonationsAddNew").click(function(event)
    {
        event.preventDefault();


        OpenCreateDialog();
    });

    function ClearDialog()
    {
        rnJQuery("#smart_donations_campaign_name").val(''),
        rnJQuery("#smart_donations_campaign_description").val(''),
        rnJQuery("#smart_donations_campaign_goal").val(0);
        rnJQuery("#smartDonationsThankYouEmail").val('');
        rnJQuery("#smartDonationsEmailSubject").val('');
        rnJQuery("#smartDonationsEmailFrom").val('');
        rnJQuery('#smartDonationsSendThankYouEmail').removeAttr('checked');

        DisableThankYouEmail();
    }


    function OpenCreateDialog()
    {
        notifications.Clear();
        jQuery('#campaignModal').modal();
        jQuery('#myModalTitle').text('Create Campaign');
        rnJQuery("#campaignSaveButton").unbind("click").click(function()
        {

            if(!EmailIsValid())
            {
                alert("Invalid email address");
                return;
            }
            rnJQuery('#campaignSaveButton').RNWait('start');
           rnJQuery(this).attr('disabled', 'disabled');
            var data={
                action:"rednao_smart_donations_add_campaign",
                name:rnJQuery("#smart_donations_campaign_name").val(),
                description:rnJQuery("#smart_donations_campaign_description").val(),
                goal:rnJQuery("#smart_donations_campaign_goal").val(),
                thank_you_email:rnJQuery('#smartDonationsThankYouEmail').val(),
                email_subject:rnJQuery('#smartDonationsEmailSubject').val(),
                email_from:rnJQuery('#smartDonationsEmailFrom').val()
            };

            notifications.Clear();
            rnJQuery.post(ajaxurl,data,ajaxCompleted);
        });


    }

    function ajaxCompleted(result)
    {
        rnJQuery('#campaignSaveButton').RNWait('stop');
        rnJQuery("#campaignSaveButton").removeAttr('disabled');
        if(result=="success")
        {
            notifications.ShowSuccess('Campaign saved successfully');
            location.reload();
        }else
        {
            notifications.ShowError(result);
        }
    }

    function EmailIsValid() {
        var email=rnJQuery('#smartDonationsEmailFrom').val();
        if(email=="")
            return true;
        expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return expr.test(email);

    }


    function OpenEditDialog(campaign) {
        notifications.Clear();
        ClearDialog();
        jQuery('#campaignModal').modal();
        jQuery('#myModalTitle').text('Create Campaign');

        rnJQuery("#campaignSaveButton").unbind("click").click(function()
        {
            if(!EmailIsValid())
            {
                alert("Invalid email address");
                return;
            }
            rnJQuery('#campaignSaveButton').RNWait('start');
            rnJQuery(this).attr('disabled', 'disabled');
            var data={
                action:"rednao_smart_donations_edit_campaign",
                campaign_id:campaign.campaign_id,
                name:rnJQuery("#smart_donations_campaign_name").val(),
                description:rnJQuery("#smart_donations_campaign_description").val(),
                thank_you_email:rnJQuery('#smartDonationsThankYouEmail').val(),
                goal:rnJQuery("#smart_donations_campaign_goal").val(),
                email_subject:rnJQuery('#smartDonationsEmailSubject').val(),
                email_from:rnJQuery('#smartDonationsEmailFrom').val()
            };

            notifications.Clear();
            rnJQuery.post(ajaxurl,data,ajaxCompleted);
        });

        rnJQuery("#smart_donations_campaign_name").val(campaign.name),
        rnJQuery("#smart_donations_campaign_description").val(campaign.description),
        rnJQuery("#smart_donations_campaign_goal").val(campaign.goal);
        rnJQuery("#smartDonationsThankYouEmail").val(campaign.thank_you_email);
        rnJQuery("#smartDonationsEmailSubject").val(campaign.email_subject);
        rnJQuery("#smartDonationsEmailFrom").val(campaign.email_from);

        if(campaign.email_subject||campaign.thank_you_email)
            rnJQuery('#smartDonationsSendThankYouEmail').attr('checked','checked');
        else
            rnJQuery('#smartDonationsSendThankYouEmail').removeAttr('checked');


        if(rnJQuery("#smartDonationsThankYouEmail").val())
            EnableThankYouEmail();
    }


    function EditCampaign(id)
    {


        for(var i=0;i<smartDonationsCampaignArray.length;i++)
        {
            if(smartDonationsCampaignArray[i].campaign_id==id)
            {
                OpenEditDialog(smartDonationsCampaignArray[i]);
            }
        }
    }

    smartDonationsEditCampaign=EditCampaign;





    /************************************************************************************* Thank You Email Code ***************************************************************************************************/
    rnJQuery('#smartDonationsSendThankYouEmail').change(SendThankYouEmailChanged);

    function SendThankYouEmailChanged()
    {
        if(rnJQuery('#smartDonationsSendThankYouEmail').is(':checked'))
            EnableThankYouEmail();
        else
            DisableThankYouEmail();


    }

    function EnableThankYouEmail()
    {
        rnJQuery('#smartDonationsThankYouEmail').removeAttr('disabled');
        rnJQuery('#smartDonationsThankYouEmail').css('background-color','#fff');

        rnJQuery('#smartDonationsEmailSubject').removeAttr('disabled');
        rnJQuery('#smartDonationsEmailSubject').css('background-color','#fff');

        rnJQuery('#smartDonationsEmailFrom').removeAttr('disabled');
        rnJQuery('#smartDonationsEmailFrom').css('background-color','#fff');

    }

    function DisableThankYouEmail()
    {
        rnJQuery('#smartDonationsThankYouEmail').attr('disabled','disabled');
        rnJQuery('#smartDonationsThankYouEmail').css('background-color','#ddd');
        rnJQuery('#smartDonationsThankYouEmail').val('');

        rnJQuery('#smartDonationsEmailSubject').attr('disabled','disabled');
        rnJQuery('#smartDonationsEmailSubject').css('background-color','#ddd');
        rnJQuery('#smartDonationsEmailSubject').val('');

        rnJQuery('#smartDonationsEmailFrom').attr('disabled','disabled');
        rnJQuery('#smartDonationsEmailFrom').css('background-color','#ddd');
        rnJQuery('#smartDonationsEmailFrom').val('');
    }


});


