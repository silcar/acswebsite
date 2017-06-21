
<?php
/**
 * Created by JetBrains PhpStorm.
 * User: edseventeen
 * Date: 3/29/13
 * Time: 9:29 AM
 * To change this template use File | Settings | File Templates.
 */

if(!defined('ABSPATH'))
    die('Forbidden');

require_once('smart-donations-license-helpers.php');
require_once(SMART_DONATIONS_DIR.'/donation_provider/donation_provider_config.php');
if(isset($_GET['mode'])&&$_GET['mode']=='pro')
{
    require_once(SMART_DONATIONS_DIR.'/smart-donations-forms-pro.php');
    return;
}

global $wpdb;



$campaigns=$wpdb->get_results("select campaign_id, name from ".SMART_DONATIONS_CAMPAIGN_TABLE);
$donationProviderNames=array();
$donationProviderNames=apply_filters('smart-donations-register-provider',$donationProviderNames);
$donationProviderNames=apply_filters('smart-donations-register-designers',$donationProviderNames);

wp_enqueue_script('jquery');
wp_enqueue_style('smart-donations-bootstrap-theme',SMART_DONATIONS_PLUGIN_URL.'css/bootstrap/bootstrap-theme.css');
wp_enqueue_style('smart-donations-bootstrap',SMART_DONATIONS_PLUGIN_URL.'css/bootstrap/bootstrap-scopped.css');
wp_enqueue_style('smart-donations-ladda',SMART_DONATIONS_PLUGIN_URL.'css/bootstrap/ladda-themeless.min.css');

wp_enqueue_script('smart-donations-bootstrap-theme',SMART_DONATIONS_PLUGIN_URL.'js/bootstrap/bootstrapUtils.js',array('isolated-slider'));
wp_enqueue_script('smart-donations-bootstrap-js',SMART_DONATIONS_PLUGIN_URL.'js/bootstrap/bootstrap.min.js',array('jquery'));
wp_enqueue_script('smart-donations-spin-js',SMART_DONATIONS_PLUGIN_URL.'js/bootstrap/spin.min.js');
wp_enqueue_script('smart-donations-ladda-js',SMART_DONATIONS_PLUGIN_URL.'js/bootstrap/ladda.min.js',array('smart-donations-spin-js'));



wp_enqueue_script('smart-donations-base-designer',plugin_dir_url(__FILE__).'donation_provider/js/SDProviderBaseDesigner.js',array('isolated-slider','smart-donations-eventmanager'));
wp_enqueue_script('smart-donations-eventmanager',plugin_dir_url(__FILE__).'js/eventmanager.js');
wp_enqueue_script('isolated-slider',plugin_dir_url(__FILE__).'js/rednao-isolated-jq.js');
wp_enqueue_script('smart-donations-jscolor',plugin_dir_url(__FILE__).'js/jscolor.js',array('isolated-slider'));
wp_enqueue_script('smart-donations-configuration',plugin_dir_url(__FILE__).'js/donationConfiguration.js',array('isolated-slider'));
wp_enqueue_script('smart-donations-configuration-wepay',plugin_dir_url(__FILE__).'js/donationConfiguration_wepay.js',array('isolated-slider','smart-donations-configuration'));
//wp_enqueue_script('smart-donations-donation-provider',plugin_dir_url(__FILE__).'js/donationProvider.js',array('isolated-slider'));
wp_enqueue_script('smart-donations-generator',plugin_dir_url(__FILE__).'js/donationGenerator.js',array('isolated-slider','smart-donations-donation-provider','smart-donations-eventmanager'));
wp_enqueue_script('smart-donations-generator-wepay',plugin_dir_url(__FILE__).'js/donationGenerator_wepay.js',array('smart-donations-generator'));
wp_enqueue_script('smart-donations-raphael',plugin_dir_url(__FILE__).'js/raphael-min.js',array('isolated-slider'));
wp_enqueue_script('smart-donations-settings',plugin_dir_url(__FILE__).'js/smartDonationsSettings.js',array_merge(array('isolated-slider','smart-donations-configuration','smart-donations-configuration-wepay','smart-donations-generator','smart-donations-donation-provider'),$donationProviderNames));
wp_enqueue_script('smart-donations-style-manager',plugin_dir_url(__FILE__).'js/smartDonationsStyleManager.js',array('isolated-slider','smart-donations-configuration','smart-donations-configuration-wepay','smart-donations-generator','smart-donations-donation-provider'));
wp_enqueue_script('smart-donations-formelements',plugin_dir_url(__FILE__).'js/formBuilder/formelements.js',array('isolated-slider'));
wp_enqueue_script('smart-donations-elementsProperties',plugin_dir_url(__FILE__).'js/formBuilder/elementsproperties.js',array('smart-donations-formelements'));
wp_enqueue_script('smart-donations-formBuilder',plugin_dir_url(__FILE__).'js/formBuilder/formbuilder.js',array('smart-donations-elementsProperties'));
wp_enqueue_script('rednao-message-manager',plugin_dir_url(__FILE__).'js/rednao-message-manager.js',array('isolated-slider'));
wp_enqueue_script('json2');


wp_enqueue_style('smart-donations-main-style',plugin_dir_url(__FILE__).'css/mainStyle.css');
wp_enqueue_style('smart-donations-Slider',plugin_dir_url(__FILE__).'css/smartDonationsSlider/jquery-ui-1.10.2.custom.min.css');
wp_enqueue_style('form-builder-boot-strap',plugin_dir_url(__FILE__).'css/formBuilder/bootstrap.min.css');
wp_enqueue_style('form-builder-custom',plugin_dir_url(__FILE__).'css/formBuilder/custom.css');



?>

<div style="height: 50px;">
<div id="sdNotifications" class="alert" style="padding: 10px;box-shadow:none;">


</div>
</div>

    <script type="text/javascript">
		var smartDonationsIPNUrl="<?php echo site_url().'?sd_ipn_trigger=1' ?>";
        var smartDonationsPluginUrl="<?php echo SMART_DONATIONS_PLUGIN_URL ?>";
		var smartFormsIsActive=<?php echo (is_plugin_active("smart-forms/smartforms.php")?"true":"false");?>;

		var smartDonationsSandbox="<?php echo SMART_DONATIONS_SANDBOX ?>";
		var smartDonationsProviders=[];
        var smartDonations_arrow_closed="<?php echo plugin_dir_url(__FILE__)?>images/arrow_right.png";
        var smartDonations_arrow_open="<?php echo plugin_dir_url(__FILE__)?>images/arrow_down.png";
        var smartDonationsSelectedProvider=null;
		var RNGlobalNotifications=null;
        var smartDonationsRootPath="<?php echo plugin_dir_url(__FILE__)?>";



        function setCurrencyOptions(provider)
        {
            var providerCurrencies;
			providerCurrencies=provider.Currencies;


            var comboCurrencies=rnJQuery("#smartDonationsCurrencyDropDown");
            comboCurrencies.empty();

            for(var i=0;i<providerCurrencies.length;i++)
                comboCurrencies.append('<option value="'+providerCurrencies[i]+'">'+providerCurrencies[i]+'</option>');

            comboCurrencies.val(providerCurrencies[0]);


        }



        function smartDonationsCurrencyChanged(element)
        {
            rnJQuery("#smartDonationsCurrency").val(rnJQuery("#smartDonationsCurrencyDropDown").val());
        }

        function smartDonationsCampaignChanged(element)
        {
            rnJQuery("#smartDonationsCampaign").val(rnJQuery("#select_campaign_id").val());
        }

        function donationDescriptionChanged(element)
        {
            rnJQuery('#smartDonationsDescription').val(rnJQuery('#smartDonationsDonationDescription').val());
        }

        function smartDonationsSelectedCountryChanged(element)
        {
            rnJQuery('#smartDonationsCountry').val(rnJQuery('#smartDonationsSelectedCountryAndLanguage').val());
        }



        function GetProviderByName(providerName)
        {
            for(var i=0;i<smartDonationsProviders.length;i++)
                if(smartDonationsProviders[i].Id==providerName)
                    return smartDonationsProviders[i];

            return;
        }

        function providerChanged() {
            SmartDonations_backFromConfiguration();
            var newProvider=rnJQuery('#rednao_smart_donations_provider').val();
			if(smartDonationsSelectedProvider!=null)
				smartDonationsSelectedProvider.ClearProviderScreen();



            smartDonationsSelectedProvider=GetProviderByName(newProvider);
			setCurrencyOptions(smartDonationsSelectedProvider);
			smartDonationsSelectedProvider.InitializeProviderScreen();
            rnJQuery("#smartDonationsProvider").val(newProvider);

            rnJQuery('#smartDonationsImageClassic').attr('src',smartDonationsSelectedProvider.ClassicImage);
            rnJQuery('#smartDonationsImageTextBox').attr('src',smartDonationsSelectedProvider.TextBoxImage);
            rnJQuery('#smartDonationsImageSlider').attr('src',smartDonationsSelectedProvider.SliderImage);
            rnJQuery('#smartDonationsImageForms').attr('src',smartDonationsSelectedProvider.FormImage);
            rnJQuery('#emailText').text("Email");
            rnJQuery('#imgEmailQuestion').hide();



        }


        function SmartDonationsInitialize()
        {

			RNGlobalNotifications=rnJQuery('#sdNotifications').RDNotifications();
			RedNaoEventManager.Publish('RegisterProvider',smartDonationsProviders);
			SmartDonationsInitializeProviders(smartDonationsProviders);
            rnJQuery( "#smartDonationRadio" ).buttonset();
            SmartDonationSettings();
            var previousFunction;
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

                    if(typeof WePay!='undefined')
                    {
                        previousFunction=WePay.show_dialog;
                        WePay.show_dialog=function(){};


                    }
                },
                close:function(event, ui){
                    smartDonationsDonationType.generator.containerName="smartDonationsPreviewContainer";
                    smartDonationsDonationType.generator.GenerateDonationItem();
                    if(previousFunction)
                    {
                        WePay.show_dialog=previousFunction;

                    }
                }
            });


            rnJQuery("#smartDonationsSaveButton").click(SmartDonationsSave);
            rnJQuery("#smartDonationsCurrencyDropDown").change(smartDonationsCurrencyChanged);
            rnJQuery("#select_campaign_id").change(smartDonationsCampaignChanged);
            rnJQuery("#smartDonationsEditImageButton").click(SmartDonationsStartStyling);
            rnJQuery('input[name=smartDonationEditStyle]').change(smartDonationEditTypeChanged);
            rnJQuery('#smartDonationsDonationDescription').change(donationDescriptionChanged);
            rnJQuery('#smartDonationsSelectedCountryAndLanguage').change(smartDonationsSelectedCountryChanged);


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
            if(typeof smartDonationsSavedEmail!='undefined')
            {
                rnJQuery('#smartDonationsEmail').val(smartDonationsSavedEmail);
            }

            if(typeof smartDonationsSavedName!='undefined')
            {
                rnJQuery('#smartDonationsName').val(smartDonationsSavedName);
            }

            if(typeof smartDonationsSavedReturningUrl!='undefined')
            {
                rnJQuery('#smartDonationsReturningUrl').val(smartDonationsSavedReturningUrl);
            }

            if(typeof smartDonationsSavedId!='undefined')
            {
                rnJQuery('#smartDonationsDonationId').val(smartDonationsSavedId);
            }

            if(typeof smartDonationsDonationProvider!='undefined')
            {
                rnJQuery("#rednao_smart_donations_provider").val(smartDonationsDonationProvider);
            }






            if(typeof smartDonationsSavedOptions!='undefined')
            {
                SmartDonations_donationTypeClicked(null,smartDonationsSavedOptions);

                if(typeof smartDonationsSavedOptions.donation_currency != 'undefined')
                    rnJQuery("#smartDonationsCurrencyDropDown").val(smartDonationsSavedOptions.donation_currency).change();

                if(typeof smartDonationsSavedOptions.compaign_id!='undefined')
                    rnJQuery("#select_campaign_id").val(smartDonationsSavedOptions.campaign_id).change();

                if(typeof smartDonationsSavedOptions.donation_description!='undefined')
                    rnJQuery('#smartDonationsDonationDescription').val(smartDonationsSavedOptions.donation_description).change();

                if(typeof smartDonationsSavedOptions.selectedCountry !='undefined')
                    rnJQuery('#smartDonationsSelectedCountryAndLanguage').val(smartDonationsSavedOptions.selectedCountry).change();

            }

            rnJQuery("#rednao_smart_donations_provider").change(providerChanged);

            rnJQuery("#imgEmailQuestion").click(function()
            {
                var dialog= rnJQuery("#emailQuestionDialog").dialog({
                    width:720,
                    height:480,
                    modal:true,
                    draggable:false,
                    resizable:false,
                    create: function(event, ui){
                        rnJQuery('.ui-dialog').wrap('<div class="smartDonationsSlider" />');

                    },
                    open: function(event, ui){
                        rnJQuery('.ui-widget-overlay').wrap('<div class="smartDonationsSlider" />');
                    }
                });


            });

        };


		function SmartDonationsInitializeProviders(providers)
		{
			if(typeof smartDonationsDonationProvider=='undefined')
				smartDonationsDonationProvider='paypal';
			var options='';
			var isFirst=true;
			for(var i=0;i<providers.length;i++)
			{
				options+='<option value="'+providers[i].Id+'" '+((providers[i].Id==smartDonationsDonationProvider)?'selected="selected"':"")+'>'+providers[i].Name+'</option>';
				isFirst=false;
			}

			rnJQuery('#rednao_smart_donations_provider').empty();
			rnJQuery('#rednao_smart_donations_provider').append(options);
			rnJQuery('#emailText').text('Email');
            providerChanged();
		}


        function SmartDonationsSave(event)
        {
			event.preventDefault();

			var button=rnJQuery(this);
			button.attr('disabled', 'disabled');
			rnJQuery(this).RNWait('start');
			RNGlobalNotifications.Clear();



            var businessElement=rnJQuery('#smart_donations_component_options input[name="business"]');
            if(businessElement.length<=0)
            {
                rnJQuery('#smart_donations_component_options').append('<input type="hidden" name="business" value="'+rnJQuery("#smartDonationsEmail").val()+'"/>');

            }else
                businessElement.val(rnJQuery("#smartDonationsEmail").val());


            var donationProviderElement=rnJQuery('#smart_donations_component_options input[name="donation_provider"]');
            donationProviderElement.val(rnJQuery("#rednao_smart_donations_provider").val());

            var donationsOptions=rnJQuery("#smart_donations_component_options, #smart_donations_component_options form").serialize();

            var stylesToSave="";

            var generator=GetCurrentGenerator();


            if(generator==null || typeof generator.styles=='undefined')
                stylesToSave=null;
            else
                stylesToSave=rnJQuery.param(smartDonationsDonationType.generator.styles);


            if(generator instanceof smartDonationsFormDonationGenerator)
            {
                stylesToSave=null;
                donationsOptions=new Object();
                var options=GetCurrentGenerator().GetOptions();
                options.smartDonationsType=rnJQuery('#smartDonationsType').val();
                options.donation_provider=rnJQuery('#smartDonationsProvider').val();
                options.campaign_id=rnJQuery('#smartDonationsCampaign').val();
                options.donation_currency=rnJQuery('#smartDonationsCurrency').val();
                options.business=rnJQuery("#smartDonationsEmail").val();
                options.returningUrl=rnJQuery("#smartDonationsReturningUrl").val();
                options.emailToNotify=rnJQuery('#smartDonationsNotifyToEmail').val();
                options.donation_description=rnJQuery('#smartDonationsDescription').val();
                options.selectedCountry=rnJQuery("#smartDonationsCountry").val();
                donationsOptions=JSON.stringify(options);
            }

            var data={
                action:"rednao_smart_donations_save",
                name:rnJQuery("#smartDonationsName").val(),
                returningURL:rnJQuery("#smartDonationsReturningUrl").val(),
                email:rnJQuery("#smartDonationsEmail").val(),
                donationId:rnJQuery("#smartDonationsDonationId").val(),
                donationType:rnJQuery("#smartDonationsType").val(),
                donation_Provider:rnJQuery("#rednao_smart_donations_provider").val(),
                styles:stylesToSave,
                donationOptions:donationsOptions
            };

			var self=this;
            rnJQuery.post(ajaxurl,data,function(result,status){data,rnJQuery(self).RNWait('stop'); ajaxCompleted(result,status);});

        }

        function GetCurrentGenerator()
        {
            if(typeof(smartDonationsDonationType)== 'undefined' || smartDonationsDonationType==null|| typeof smartDonationsDonationType.generator =='undefined')
                return null;
            return smartDonationsDonationType.generator;
        }

        function ajaxCompleted(result,status)
        {

            var obj=rnJQuery.parseJSON(result);
			if(obj.Success=='y')
				RNGlobalNotifications.ShowSuccess('Information saved successfully');
			else
				RNGlobalNotifications.ShowError(obj.Message);

            if(obj.DonationId!="0")
                rnJQuery("#smartDonationsDonationId").val(obj.DonationId)

            var button=rnJQuery("#smartDonationsSaveButton");
            button.removeAttr("disabled");
            button.text("Save");
        }

        function SmartDonationsSerializeObject(array)
        {
            var o={};

            rnJQuery.each(array, function() {
                if (o[this.name] !== undefined) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            return o;
        }


    </script>


<div class="bootstrap-wrapper">


<div style="width: 100%; display: block; margin: 5px 0 10px 0;padding: 0;height: 30px;">
<div class="updated fade below-h2 rednaoMessageManager" style="margin: 5px 0 10px 0; height: 0px; display: none; background-color: #EAFFFD; border-color: #B7E9E4; border-style: dotted;"></div>
</div>




<form id='smart_donations_general_options'>
    <div id="rednaoSmartDonaitions">

        <input type="hidden" name="donationId" id="smartDonationsDonationId" value=""/>




		<ul class="nav nav-tabs rednao-settings" role="tablist">
			<li class="active"><a href="#home" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-search" ></span>Basic</a></li>
			<li><a href="#profile" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-cog" ></span>Advanced</a></li>
			<li>
				<button style="margin-left: 530px;width:100px;cursor: hand;cursor: pointer;" class="btn btn-success ladda-button" id="smartDonationsSaveButton"  data-style="expand-left" onclick="return false;" >
					<span class="glyphicon glyphicon-floppy-disk"></span><span class="ladda-label">Save</span>
				</button>
			</li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content rednao-settings" style="width: 1200px;margin-bottom: 10px;">
			<div class="tab-pane active" id="home">
				<div class="category form-horizontal" >
					<div class='form-group' style="margin-bottom: 5px;">
						<label class='control-label col-xs-1' style="width: 150px">Donation Provider</label>
						<div class='col-xs-4'><select name="smartDonationsProvider" id="rednao_smart_donations_provider" class="form-control"></select></div>
					</div>


					<div class='form-group' style="margin-bottom: 5px;">
						<label class='control-label col-xs-3' style="width: 150px">Campaign</label>
						<div class='col-xs-4'><select name="campaign_id" id="select_campaign_id" class="form-control">
								<option value="0">Default</option>
								<?php
								foreach($campaigns  as $campaign)
								{
									echo "<option value='$campaign->campaign_id'>$campaign->name</option>";
								}
								?>
							</select>
						</div>
					</div>


					<div class='form-group' style="margin-bottom: 5px;">
						<label class='control-label col-xs-3' style="width: 150px">Name</label>
						<div class='col-xs-4'>
							<input type="text" class="form-control" name="smartDonationsName" id="smartDonationsName"/>
						</div>
						<span class="description" style="margin-bottom:5px;"> *The name of the donation, this name is displayed in the donations list</span>
					</div>

					<div class='form-group' id="divEmail" style="margin-bottom: 5px;">
						<label class='control-label col-xs-3' id="emailText" style="width: 150px">Email</label>
						<div class='col-xs-4'><input type="text" name="business" id="smartDonationsEmail" class="form-control"/> </div>
						<span class="description"> *Email Used for the donation</span>
					</div>


				</div>

			</div>
			<div class="tab-pane" id="profile">
				<div class="category form-horizontal"  >
					<div class='form-group' style="margin-bottom: 5px;">
						<label class='control-label col-xs-3' id="emailText" style="width: 150px">Currency</label>
						<div class='col-xs-4'><select id="smartDonationsCurrencyDropDown" class="form-control" name="donation_currency"></select></div>
						<span class="description">*the selected currency for the donation</span>
					</div>
					<div class='form-group' style="margin-bottom: 5px;">
						<label class='control-label col-xs-3' id="emailText" style="width: 150px">Returning Url</label>
						<div class='col-xs-4'><input type="text" class="form-control" id="smartDonationsReturningUrl"/></div>
						<span class="description">*Page displayed after he does a donation</span>
					</div>
					<div class='form-group' style="margin-bottom: 5px;">
						<label class='control-label col-xs-3' id="emailText" style="width: 150px">Donation Description</label>
						<div class='col-xs-4'><input type="text" class="form-control" id="smartDonationsDonationDescription"/></div>
						<span class="description">*This text is going to be shown in the paypal invoice</span>
					</div>

					<div class='form-group' style="margin-bottom: 5px;">
						<label style="width: 150px;" class=" control-label col-xs-3 confLanguage">Donation button country and language</label>
						<div class='col-xs-4'><select class="confLanguage form-control" id="smartDonationsSelectedCountryAndLanguage" name="selectedCountry"><option value="en_AL">Albania - English</option><option value="en_DZ">Algeria - English</option><option value="en_AD">Andorra - English</option><option value="en_AO">Angola - English</option><option value="en_AI">Anguilla - English</option><option value="en_AG">Antigua and Barbuda - English</option><option value="en_AR">Argentina - English</option><option value="en_AM">Armenia - English</option><option value="en_AW">Aruba - English</option><option value="en_AU">Australia - Australian English</option><option value="de_AT">Austria - German</option><option value="en_AT">Austria - English</option><option value="en_AZ">Azerbaijan Republic - English</option><option value="en_BS">Bahamas - English</option><option value="en_BH">Bahrain - English</option><option value="en_BB">Barbados - English</option><option value="en_BE">Belgium - English</option><option value="nl_BE">Belgium - Dutch</option><option value="fr_BE">Belgium - French</option><option value="en_BZ">Belize - English</option><option value="en_BJ">Benin - English</option><option value="en_BM">Bermuda - English</option><option value="en_BT">Bhutan - English</option><option value="en_BO">Bolivia - English</option><option value="en_BA">Bosnia and Herzegovina - English</option><option value="en_BW">Botswana - English</option><option value="pt_BR">Brazil - Portuguese</option><option value="en_BR">Brazil - English</option><option value="en_BN">Brunei - English</option><option value="en_BG">Bulgaria - English</option><option value="en_BF">Burkina Faso - English</option><option value="en_BI">Burundi - English</option><option value="en_KH">Cambodia - English</option><option value="en_CA">Canada - English</option><option value="fr_CA">Canada - French</option><option value="en_CV">Cape Verde - English</option><option value="en_KY">Cayman Islands - English</option><option value="en_TD">Chad - English</option><option value="en_CL">Chile - English</option><option value="en_C2">China - English</option><option value="zh_C2">China - Simplified Chinese</option><option value="en_CO">Colombia - English</option><option value="en_KM">Comoros - English</option><option value="en_CK">Cook Islands - English</option><option value="en_CR">Costa Rica - English</option><option value="en_HR">Croatia - English</option><option value="en_CY">Cyprus - English</option><option value="en_CZ">Czech Republic - English</option><option value="en_CD">Democratic Republic of the Congo - English</option><option value="da_DK">Denmark - Danish</option><option value="en_DK">Denmark - English</option><option value="en_DJ">Djibouti - English</option><option value="en_DM">Dominica - English</option><option value="en_DO">Dominican Republic - English</option><option value="en_EC">Ecuador - English</option><option value="en_EG">Egypt - English</option><option value="en_SV">El Salvador - English</option><option value="en_ER">Eritrea - English</option><option value="en_EE">Estonia - English</option><option value="ru_EE">Estonia - Russian</option><option value="fr_EE">Estonia - French</option><option value="es_EE">Estonia - Spanish</option><option value="zh_EE">Estonia - Simplified Chinese</option><option value="en_ET">Ethiopia - English</option><option value="en_FK">Falkland Islands - English</option><option value="en_FO">Faroe Islands - English</option><option value="en_FJ">Fiji - English</option><option value="en_FI">Finland - English</option><option value="fr_FR">France - French</option><option value="en_FR">France - English</option><option value="en_GF">French Guiana - English</option><option value="en_PF">French Polynesia - English</option><option value="en_GA">Gabon Republic - English</option><option value="en_GM">Gambia - English</option><option value="en_GE">Georgia - English</option><option value="de_DE">Germany - German</option><option value="en_DE">Germany - English</option><option value="en_GI">Gibraltar - English</option><option value="en_GR">Greece - English</option><option value="en_GL">Greenland - English</option><option value="en_GD">Grenada - English</option><option value="en_GP">Guadeloupe - English</option><option value="en_GT">Guatemala - English</option><option value="en_GN">Guinea - English</option><option value="en_GW">Guinea Bissau - English</option><option value="en_GY">Guyana - English</option><option value="en_HN">Honduras - English</option><option value="en_HK">Hong Kong - English</option><option value="zh_HK">Hong Kong - Traditional Chinese</option><option value="en_HU">Hungary - English</option><option value="en_IS">Iceland - English</option><option value="en_IN">India - English</option><option value="en_ID">Indonesia - English</option><option value="en_IE">Ireland - English</option><option value="en_IL">Israel - English</option><option value="he_IL">Israel - Hebrew</option><option value="it_IT">Italy - Italian</option><option value="en_IT">Italy - English</option><option value="en_JM">Jamaica - English</option><option value="ja_JP">Japan - Japanese</option><option value="en_JP">Japan - English</option><option value="en_JO">Jordan - English</option><option value="en_KZ">Kazakhstan - English</option><option value="en_KE">Kenya - English</option><option value="en_KI">Kiribati - English</option><option value="en_KW">Kuwait - English</option><option value="en_KG">Kyrgyzstan - English</option><option value="en_LA">Laos - English</option><option value="en_LV">Latvia - English</option><option value="en_LS">Lesotho - English</option><option value="en_LI">Liechtenstein - English</option><option value="en_LT">Lithuania - English</option><option value="en_LU">Luxembourg - English</option><option value="en_MG">Madagascar - English</option><option value="en_MW">Malawi - English</option><option value="en_MY">Malaysia - English</option><option value="en_MV">Maldives - English</option><option value="en_ML">Mali - English</option><option value="en_MT">Malta - English</option><option value="en_MH">Marshall Islands - English</option><option value="en_MQ">Martinique - English</option><option value="en_MR">Mauritania - English</option><option value="en_MU">Mauritius - English</option><option value="en_YT">Mayotte - English</option><option value="es_MX">Mexico - Spanish</option><option value="en_MX">Mexico - English</option><option value="en_FM">Micronesia - English</option><option value="en_MN">Mongolia - English</option><option value="en_MS">Montserrat - English</option><option value="en_MA">Morocco - English</option><option value="en_MZ">Mozambique - English</option><option value="en_NA">Namibia - English</option><option value="en_NR">Nauru - English</option><option value="en_NP">Nepal - English</option><option value="nl_NL">Netherlands - Dutch</option><option value="en_NL">Netherlands - English</option><option value="en_AN">Netherlands Antilles - English</option><option value="en_NC">New Caledonia - English</option><option value="en_NZ">New Zealand - English</option><option value="en_NI">Nicaragua - English</option><option value="en_NE">Niger - English</option><option value="en_NU">Niue - English</option><option value="en_NF">Norfolk Island - English</option><option value="no_NO">Norway - Norwegian</option><option value="en_NO">Norway - English</option><option value="en_OM">Oman - English</option><option value="en_PW">Palau - English</option><option value="en_PA">Panama - English</option><option value="en_PG">Papua New Guinea - English</option><option value="en_PE">Peru - English</option><option value="en_PH">Philippines - English</option><option value="en_PN">Pitcairn Islands - English</option><option value="pl_PL">Poland - Polish</option><option value="en_PL">Poland - English</option><option value="en_PT">Portugal - English</option><option value="en_QA">Qatar - English</option><option value="en_CG">Republic of the Congo - English</option><option value="en_RE">Reunion - English</option><option value="en_RO">Romania - English</option><option value="ru_RU">Russia - Russian</option><option value="en_RU">Russia - English</option><option value="en_RW">Rwanda - English</option><option value="en_KN">Saint Kitts and Nevis Anguilla - English</option><option value="en_PM">Saint Pierre and Miquelon - English</option><option value="en_VC">Saint Vincent and Grenadines - English</option><option value="en_WS">Samoa - English</option><option value="en_SM">San Marino - English</option><option value="en_ST">São Tomé and Príncipe - English</option><option value="en_SA">Saudi Arabia - English</option><option value="en_SN">Senegal - English</option><option value="en_RS">Serbia - English</option><option value="en_SC">Seychelles - English</option><option value="en_SL">Sierra Leone - English</option><option value="en_SG">Singapore - English</option><option value="en_SK">Slovakia - English</option><option value="en_SI">Slovenia - English</option><option value="en_SB">Solomon Islands - English</option><option value="en_SO">Somalia - English</option><option value="en_ZA">South Africa - English</option><option value="en_KR">South Korea - English</option><option value="es_ES">Spain - Spanish</option><option value="en_ES">Spain - English</option><option value="en_LK">Sri Lanka - English</option><option value="en_SH">St. Helena - English</option><option value="en_LC">St. Lucia - English</option><option value="en_SR">Suriname - English</option><option value="en_SJ">Svalbard and Jan Mayen Islands - English</option><option value="en_SZ">Swaziland - English</option><option value="sv_SE">Sweden - Swedish</option><option value="en_SE">Sweden - English</option><option value="de_CH">Switzerland - German</option><option value="fr_CH">Switzerland - French</option><option value="en_CH">Switzerland - English</option><option value="zh_TW">Taiwan - Traditional Chinese</option><option value="en_TW">Taiwan - English</option><option value="en_TJ">Tajikistan - English</option><option value="en_TZ">Tanzania - English</option><option value="th_TH">Thailand - Thai</option><option value="en_TH">Thailand - English</option><option value="en_TG">Togo - English</option><option value="en_TO">Tonga - English</option><option value="en_TT">Trinidad and Tobago - English</option><option value="en_TN">Tunisia - English</option><option value="tr_TR">Turkey - Turkish</option><option value="en_TR">Turkey - English</option><option value="en_TM">Turkmenistan - English</option><option value="en_TC">Turks and Caicos Islands - English</option><option value="en_TV">Tuvalu - English</option><option value="en_UG">Uganda - English</option><option value="en_UA">Ukraine - English</option><option value="en_AE">United Arab Emirates - English</option><option value="en_GB">United Kingdom - English</option><option value="fr_GB" selected="">United Kingdom - French</option><option value="en_US" selected="selected">United States - English</option><option value="fr_US">United States - French</option><option value="es_US">United States - Spanish</option><option value="zh_US">United States - Simplified Chinese</option><option value="en_UY">Uruguay - English</option><option value="en_VU">Vanuatu - English</option><option value="en_VA">Vatican City State - English</option><option value="en_VE">Venezuela - English</option><option value="en_VN">Vietnam - English</option><option value="en_VG">Virgin Islands (British) - English</option><option value="en_WF">Wallis and Futuna Islands - English</option><option value="en_YE">Yemen - English</option><option value="en_ZM">Zambia - English</option><option value="en_GB">International</option></select></div>
					</div>
				</div>
			</div>
		</div>
</form>


<form id='smart_donations_component_options' action="https://www.paypal.com/cgi-bin/webscr" method="post" class="donationForm" target="_blank">


        <!--Item Container--->
        <input type="hidden" id="smartDonationsType" name="smartDonationsType"/>
        <input type="hidden" id="smartDonationsProvider" name="donation_provider"/>
        <input type="hidden" id="smartDonationsCampaign" name="campaign_id" value="0"/>
        <input type="hidden" id="smartDonationsCurrency" name="donation_currency" value='USD'/>
        <input type="hidden" id="smartDonationsDescription" name="donation_description" value='Donation'/>
        <input type="hidden" id="smartDonationsCountry" name="selectedCountry" value='en_US'/>



        <div id="smartdonationsItemsContainer">
            <div id="smartDonationsItemsContainerHeader">
                <span>Select a Donation Type</span>
            </div>
            <div id="smartDonationsItemsContainerBody">
                <div id="smartDonationsSlideAnimation">

                    <div id="smartDonationsItemsList">
                        <div class="smartDonationsItem" id="smartDonationsClassic">
                            <input type="hidden"  value="classic"/>
                            <img id="smartDonationsImageClassic" src="<?php echo plugin_dir_url(__FILE__)?>images/classic_donation.png" alt="" >
                        </div>

                        <div class="smartDonationsItem">
                            <input type="hidden"  value="textbox"/>
                            <img id="smartDonationsImageTextBox" src="<?php echo plugin_dir_url(__FILE__)?>images/text_box_donation.png" alt="">
                        </div>

                        <div class="smartDonationsItem" id="smartDonationsThreeButtons">
                            <input type="hidden"  value="threeButtons"/>
                            <img  src="<?php echo plugin_dir_url(__FILE__)?>images/three_buttons_donation.png" alt="">
                        </div>

                        <div class="smartDonationsItem">
                            <input type="hidden"  value="slider"/>
                            <img  id="smartDonationsImageSlider" src="<?php echo plugin_dir_url(__FILE__)?>images/slider_donation.png" alt="">
                        </div>

                        <?php
                        if(smart_donations_check_license_with_options($error)||$error!=null)
                        {
                        ?>

                        <div class="smartDonationsItem">
                            <input type="hidden"  value="forms"/>
                            <img  id="smartDonationsImageForms" src="<?php echo plugin_dir_url(__FILE__)?>images/form_donation.png" alt="">
                        </div>
                        <?php } else{?>


                        <div class="smartDonationsItem">
                            <input type="hidden"  />
                            <a href="?page=smart_donations_menu&action=add&mode=pro">
                            <img id="smartDonationsImageForms" src="<?php echo plugin_dir_url(__FILE__)?>images/form_donation.png" alt=""></a>
                        </div>
                        <?php }?>

                    </div>




                    <div id="smartDonationsConfiguration">
                        <img id="smartDonationsBackFromConfiguration" src="<?php echo plugin_dir_url(__FILE__)?>images/arrow_back.png" alt="">
                        <span id="smartDonationsItemTitle">Test</span>


                        <div id="smartDonationsConfigurationFields" class="smartDonationsCustomFields">

                        </div>


                        <div id="smartDonationsPreview" >
                            <img id="smartDonationsEditImageButton" src="<?php echo plugin_dir_url(__FILE__)?>images/editButton.png" style="height: 25px; position: relative;display: inline;float:right;margin-top:5px; cursor: hand;cursor:pointer;">
                            <span id="smartDonationsPreviewText">Preview</span>

                            <div id="smartDonationsPreviewContainer">

                            </div>
                        </div>


                    </div>





                </div>


            </div>
        </div>

    </div>

</form>

<?php  ?>

    <div id="emailQuestionDialog" title="We Pay Id" style="display: none">
        <p>You can get the donation id on the code that you get when you create a donation button</p>
        <img src="<?php echo plugin_dir_url(__FILE__)?>images/wepay_demo.png">
    </div>

    <div id="smartDonationsEditWindow" title="Edit Time!! Click an element to edit it">

        <div id="smartDonationsEditionArea" class="smartDonationsCustomFields smartDonationsEditionArea">

        </div>

        <div id="smartDonationsEditionCSSArea" style="display:none" class="smartDonationsCustomFields smartDonationsEditionArea">
            <span>Here you can add CSS to customize the elemente like you want (example: width:10px;)</span>
            <textarea id="smartDonationsCSS" style="display: block; height: 250px;width: 680px;">

            </textarea>

            <button id="smartDonationsApplyStyle">Apply</button>
        </div>

        <div id="smartDonationRadio" class="smartDonationsSlider" style="text-align: right;width: 674px;">
            <input type="radio" id="radio1" value="basic"  name="smartDonationEditStyle"  checked="checked" /><label style="width:100px" for="radio1">Basic</label>
            <input type="radio" id="radio2"  value="advanced" name="smartDonationEditStyle" /><label label style="width:100px;margin-left:-5px;" for="radio2">Advanced</label>
        </div>


        <div id="smartDonationsPreviewEdition">
               <div id="smartDonationsPreviewEditionContainer" style="margin-top: 20px;"></div>

        </div>
    </div>

<div  id="rednaoPropertiesPanel" style="top: 74px; left: 711px; display: none;">
    <div class="arrow" ></div>
    <h3 class="rednaopopover-title">Form Name</h3>

    <div class="rednaopopover-content">
        <div class="rednaopropertiesform">
            <div id="rednaoPropertiesList" style="margin:0;padding:0;">
                <label class="control-label" id="rednaoFormTitle">Form Name</label>
                <input class="input-large field" data-type="input" type="text" name="name" id="name" value="Form Name">
            </div>
            <div>
                <hr>
                <button id="rednaoPropertySave" class="rednaoBtn rednaoBtnSave">Save</button>
                <button id="rednaoPropertyCancel" class="rednaoBtn rednaoBtnCancel">Cancel</button>
            </div>

        </div>
    </div>
</div>


</div>

