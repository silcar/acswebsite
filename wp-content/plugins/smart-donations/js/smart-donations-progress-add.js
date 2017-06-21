var smartDonationsDonationType="";
var smartDonationsProgressTypeSelected;
rnJQuery(function()
{
    var Notification=rnJQuery('#RNNotifications').RDNotifications();
    rnJQuery('#smartDonationsBackFromConfiguration').click(SmartDonations_backFromConfiguration);
    rnJQuery('.smartDonationsItem').click(function(){SmartDonations_ProgressClicked(this)});
    rnJQuery( "#smartDonationRadio" ).buttonset();
    var configurationOptions=rnJQuery("#smartDonationsItemsList");
    var configurationSettings=rnJQuery("#smartDonationsConfiguration");
    rnJQuery("#smartDonationsEditImageButton").click(SmartDonationsStartStyling);
    var top = configurationOptions.offset().top-configurationSettings.offset().top;
    var left = configurationOptions.offset().left-configurationSettings.offset().left;
    left+=configurationOptions.width()+2;
    configurationSettings.css("top", top);
    configurationSettings.css("left", left);


    rnJQuery('input[name=smartDonationEditStyle]').change(smartDonationEditTypeChanged);
    function smartDonationEditTypeChanged()
    {
        var typeOfEdition=rnJQuery('input[name=smartDonationEditStyle]:checked').val();

        if(typeOfEdition=='basic')
        {
            rnJQuery('#smartDonationsEditionArea').show();
            rnJQuery('#smartDonationsEditionCSSArea').hide();
        }

        if(typeOfEdition=='advanced')
        {
            rnJQuery('#smartDonationsEditionArea').hide();
            rnJQuery('#smartDonationsEditionCSSArea').show();
        }

    }


    smartDonationsEditDialog= rnJQuery("#smartDonationsEditWindow").dialog({
        width:720,
        height:480,
        modal:true,
        draggable:false,
        resizable:false,
        autoOpen:false,
        create: function(event, ui){
            rnJQuery('.ui-dialog').wrap('<div class="smartDonationsSlider" />');
        },
        open: function(event, ui){
            rnJQuery('.ui-widget-overlay').wrap('<div class="smartDonationsSlider" />');
            previousFunction=null;
            rnJQuery("#smartDonationsEditionArea").html('');
            var generator=smartDonationsDonationType.generator;
            generator.containerName="smartDonationsPreviewEditionContainer";
            generator.GenerateDonationItem();

        },
        close:function(event, ui){
            smartDonationsDonationType.generator.containerName="smartDonationsPreviewContainer";
            smartDonationsDonationType.generator.GenerateDonationItem();

        }
    });

    function SmartDonations_ProgressClicked(div,progressOptions) {
        if(progressOptions)
        {
            smartDonationsProgressTypeSelected= progressOptions.progressType;
            progressOptions.isNew=false;
        }else
        {
            progressOptions={};
            progressOptions.isNew=true;

            smartDonationsProgressTypeSelected= rnJQuery(div).find(':hidden').val();
        }

        progressOptions.Goal=4000;
        progressOptions.Amount=2000;
        progressOptions.Donators=10;



        var progressItem=null;
        rnJQuery("#smartDonationsProgressType").val(smartDonationsProgressTypeSelected);
        rnJQuery('#smartDonationsPreview').css('height','120px');
        rnJQuery('#smartDonationsConfigurationFields').css('height','300');
        if(smartDonationsProgressTypeSelected=='progressBar')
        {
            rnJQuery('#smartDonationsPreview').css('height','355px');
            rnJQuery('#smartDonationsConfigurationFields').css('height','65px');
            progressItem=new SmartDonationsConfigurationProgressIndicator('smartDonationsPreviewContainer',progressOptions);
        }else if(smartDonationsProgressTypeSelected=='panels'){
            progressItem=new SmartDonationsConfigurationPanels('smartDonationsPreviewContainer',progressOptions);
        }
        else
        {
            throw "Invalid progress type";
        }

        smartDonationsDonationType=progressItem;

        if(progressItem!=null)
        {
            progressItem.fillConfiguration();
            progressItem.generator.GenerateDonationItem();
            rnJQuery("#smartDonationsSlideAnimation").animate({"left":"-703px"},250/*,function(){rnJQuery("#smartDonationsSlideAnimation").hide();}*/);
            return progressItem;
        }

    }

    function SmartDonations_backFromConfiguration() {
        smartDonationsDonationType=null;
        rnJQuery("#smartDonationsSlideAnimation").animate({"left":"0"},250/*,function(){rnJQuery("#smartDonationsSlideAnimation").hide();}*/);
    }






    /************************************************************************************* Saving ***************************************************************************************************/

    rnJQuery("#smartDonationsSaveButton").click(SmartDonationsSave);
    function SmartDonationsSave(event)
    {
        if(typeof smartDonationsDonationType=='undefined'|| !smartDonationsDonationType)
        {
            Notification.ShowError('Please select a progress indicator first');
            return;
        }


        event.preventDefault();
        var button=rnJQuery(this);
        button.focus();
        button.attr('disabled', 'disabled');
        button.text("Saving...");

        var progressOptions=rnJQuery("#smart_donations_component_options, #smart_donations_component_options form").serialize();

        var stylesToSave="";

        var generator=smartDonationsDonationType;



        if(generator==null)
            stylesToSave='';
        else
            stylesToSave=rnJQuery.param(smartDonationsDonationType.generator.styles);

        var data={
            action:"rednao_smart_donations_save_progress_bar",
            progress_name:rnJQuery("#tb_progress_name").val(),
            campaign_id:rnJQuery("#select_campaign_id").val(),
            progress_id:rnJQuery("#smartDonationsProgressId").val(),
            progress_type:smartDonationsProgressTypeSelected,
            styles:stylesToSave,
            options:progressOptions
        };

        rnJQuery("#smartDonationsSaveButton").RNWait('start');
        rnJQuery.post(ajaxurl,data,ajaxCompleted);

    }

    function ajaxCompleted(result,status)
    {
        rnJQuery("#smartDonationsSaveButton").RNWait('stop');
        var obj=rnJQuery.parseJSON(result);
        if(obj.Message=='saved')
            Notification.ShowSuccess('Progress bar saved successfully');
        else
            Notification.ShowError(obj.Message);

        if(obj.progress_id!="0")
            rnJQuery("#smartDonationsProgressId").val(obj.progress_id)

        var button=rnJQuery("#smartDonationsSaveButton");
        button.removeAttr("disabled");
        button.text("Save");
    }




    /************************************************************************************* Loading ***************************************************************************************************/
    if(typeof smartDonationsSavedProgress_Id!='undefined'&&smartDonationsSavedProgress_Id!=null)
    {
        smartDonationsSavedOptions.progressType=smartDonationsSavedProgressType;
        rnJQuery("#smartDonationsProgressId").val(smartDonationsSavedProgress_Id);
        rnJQuery("#tb_progress_name").val(smartDonationsSavedName);
        rnJQuery("#select_campaign_id").val(smartDonationsSavedCampaign_Id);
        SmartDonations_ProgressClicked(null,smartDonationsSavedOptions);
        SmartDonationsFillConfiguration(smartDonationsSavedOptions);
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





});