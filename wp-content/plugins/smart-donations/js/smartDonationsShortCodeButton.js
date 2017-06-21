(function() {
    javascriptUrl='';
    tinymce.create('tinymce.plugins.rednao_smart_donations', {
        init : function(ed, url) {
            javascriptUrl=url.substring(0,url.length-3);
            // Register command for when button is clicked
            ed.addCommand('rednao_smart_donations_short_code_clicked', function(a,donationId) {
                if(rnJQuery('#redNaoSelection').val()=='button')
                    tinymce.execCommand('mceInsertContent', false, '[sdonations]'+donationId+'[/sdonations]');
                if(rnJQuery('#redNaoSelection').val()=='progress')
                    tinymce.execCommand('mceInsertContent', false, '[sdprogress]'+donationId+'[/sdprogress]');
                if(rnJQuery('#redNaoSelection').val()=='wall')
                {
                    var shortcode="[sddonwall ";
                   // shortcode+='Title="'+rnJQuery('#smartDonationsWallTitle').val()+'" ';
                    shortcode+='CurrencySign="'+rnJQuery('#smartDonationsCurrencySign').val()+'" ';
                    shortcode+='DecimalSign="'+rnJQuery('#smartDonationsDecimalSign').val()+'" ';
                    shortcode+='ThousandSeparator="'+rnJQuery('#smartDonationsThousandSeparator').val()+'" ';
                    shortcode+='DecimalSign="'+rnJQuery('#smartDonationsDecimalSign').val()+'" ';
                    shortcode+='NumberOfDonors="'+rnJQuery('#smartDonationsNumberOfDonors').val()+'" ';
                    shortcode+="]"+rnJQuery('#smartDonationsCampaign').val()+'[/sddonwall] ';
                    tinymce.execCommand('mceInsertContent', false, shortcode);

                }
                rnJQuery("#smartdonationsShortCodeDialog").dialog('close');
                rnJQuery("#smartdonationsShortCodeDialog").remove();
            }),

            // Register buttons - trigger above command when clicked
            ed.addButton('rednao_smart_donations_button', {title : 'Smart Donations', image: javascriptUrl + '/images/short_code_button.png',
            onclick:function()
            {
                var data={
                    action:"rednao_smart_donations_list"
                };

                rnJQuery.post(ajaxurl,data,ajaxCompleted);

            }});
        }
    });


    tinymce.PluginManager.add('rednao_smart_donations_button', tinymce.plugins.rednao_smart_donations);
})();
var smartDonationsShortCodeDialog;
function ajaxCompleted(result,status)
{

    if(smartDonationsShortCodeDialog==null)
    {
        var smartDonationsPopUpForm='<div style=""><div style="display: block;margin-bottom: 10px;"><select id="redNaoSelection"><option value="button">Donation Button</option><option value="progress">Progress Indicator</option><option value="wall">Donation Wall(Pro)</option></select></div> <div id="smartdonationsShortCodeDialog"  title="Basic modal dialog"><select id="smartDonationsDonationList">';
        smartDonationsPopUpForm+='</select></div><div id="sddonationWallOptions" style="display: none">' +
        '<div style="display: none;margin-bottom: 10px;"><label>Title</label><input id="smartDonationsWallTitle" type="text"/></div>' +
        '<div style="display: block;margin-bottom: 10px;"><label>Campaign</label><select id="smartDonationsCampaign"></select></div>' +
        '<div style="display: block;margin-bottom: 10px;"><label>Currency Sign</label><input id="smartDonationsCurrencySign" style="width:50px;text-align:center;" type="text" value="$"/></div>' +
        '<div style="display: block;margin-bottom: 10px;"><label>Decimal Sign</label><input id="smartDonationsDecimalSign" style="width:50px;text-align:center;" type="text" value="."/></div>' +
        '<div style="display: block;margin-bottom: 10px;"><label>Thousand Separator</label><input id="smartDonationsThousandSeparator" style="width:50px;text-align:center;" type="text" value=","></div>' +
        '<div style="display: block;margin-bottom: 10px;"><label>Number of donors to show</label><input id="smartDonationsNumberOfDonors" style="width:50px;text-align:center;" type="text" value="10"/></div></div></div>';
        var dialog=rnJQuery(smartDonationsPopUpForm);

        smartDonationsShortCodeDialog=dialog.dialog({
        modal:true,
        draggable:false,
        title:'Select a Donation or Progress ',
        resizable:false,
        buttons:[
            {text: "Apply", click: function() {tinymce.execCommand('rednao_smart_donations_short_code_clicked', false, rnJQuery('#smartDonationsDonationList').val())}},
            {text: "Cancel", click: function() {rnJQuery(this).dialog("close")}}
        ],
            create: function(event, ui){
                rnJQuery('.ui-dialog').wrap('<div class="smartDonationsSlider" />');
            },
            open: function(event, ui){
                rnJQuery('.ui-widget-overlay').wrap('<div class="smartDonationsSlider" />');
                rnJQuery(".smartDonationsConfigurationFields").val('');
            }
        });
    }else{
        smartDonationsShortCodeDialog.dialog('open');
        rnJQuery('#redNaoSelection').val('button');
    }

    ajaxDonationsCompleted(result);

    function ajaxDonationsCompleted(result) {
        var donationArray=rnJQuery.parseJSON(result);
        var options="";
        for(var i=0;i<donationArray.length;i++)
        {
            options+=' <option value="'+donationArray[i].Id+'">'+donationArray[i].Name+'</option>';
        }

        rnJQuery('#smartDonationsDonationList').empty().append(options);
    }

    rnJQuery('#sddonationWallOptions').css('display','none');

    rnJQuery("#redNaoSelection").change(function(){
            rnJQuery('#smartDonationsDonationList').css('display','block');
            if(rnJQuery("#redNaoSelection").val()=='button')
            {
                var data={
                    action:"rednao_smart_donations_list"
                };


            }else
                if(rnJQuery("#redNaoSelection").val()=='progress')
                {
                    var data={
                        action:"rednao_smart_progress_donations_list"
                    };

                }
            else
                {
                    var data={
                        action:"rednao_smart_donations_campaign_list"
                    };

                    if(smartDonationsLc==0)
                    {
                        alert('Sorry you need a license to use this feature');
                        return;
                    }

                    rnJQuery.post(ajaxurl,data,function(result)
                    {
                        var donationArray=rnJQuery.parseJSON(result);
                        var options="";
                        for(var i=0;i<donationArray.length;i++)
                        {
                            options+=' <option value="'+donationArray[i].Id+'">'+donationArray[i].Name+'</option>';
                        }
                        rnJQuery('#smartDonationsCampaign').empty().append(options);
                        rnJQuery('#sddonationWallOptions').css('display','block');
                        rnJQuery('#smartDonationsDonationList').css('display','none');

                    });
                    return;


                }

            rnJQuery.post(ajaxurl,data,ajaxDonationsCompleted);


        }
    );



}


