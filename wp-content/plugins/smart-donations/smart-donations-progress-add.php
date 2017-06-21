
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

wp_enqueue_style('smart-donations-bootstrap-theme',SMART_DONATIONS_PLUGIN_URL.'css/bootstrap/bootstrap-theme.css');
wp_enqueue_style('smart-donations-bootstrap',SMART_DONATIONS_PLUGIN_URL.'css/bootstrap/bootstrap-scopped.css');


    global $wpdb;

    $campaigns=$wpdb->get_results("select campaign_id, name from ".SMART_DONATIONS_CAMPAIGN_TABLE);

wp_enqueue_script('jquery');
wp_enqueue_script('isolated-slider',plugin_dir_url(__FILE__).'js/rednao-isolated-jq.js');
wp_enqueue_script('smart-donations-progress-add',plugin_dir_url(__FILE__).'js/smart-donations-progress-add.js',array('isolated-slider'));
wp_enqueue_script('smart-donations-progress-config',plugin_dir_url(__FILE__).'js/smart-donations-progress-config.js',array('smart-donations-progress-add'));
wp_enqueue_script('smart-donations-progress-gen',plugin_dir_url(__FILE__).'js/smart-donations-progress-gen.js',array('smart-donations-progress-add'));
wp_enqueue_script('smart-donations-jscolor',plugin_dir_url(__FILE__).'js/jscolor.js',array('isolated-slider'));
wp_enqueue_script('smart-donations-raphael',plugin_dir_url(__FILE__).'js/raphael-min.js',array('isolated-slider'));
wp_enqueue_script('smart-donations-style-manager',plugin_dir_url(__FILE__).'js/smartDonationsStyleManager.js',array('isolated-slider'));



wp_enqueue_style('smart-donations-main-style',plugin_dir_url(__FILE__).'css/mainStyle.css');
wp_enqueue_style('smart-donations-Slider',plugin_dir_url(__FILE__).'css/smartDonationsSlider/jquery-ui-1.10.2.custom.min.css');
wp_enqueue_style('smart-donations-ladda',SMART_DONATIONS_PLUGIN_URL.'css/bootstrap/ladda-themeless.min.css');
wp_enqueue_script('smart-donations-bootstrap-theme',SMART_DONATIONS_PLUGIN_URL.'js/bootstrap/bootstrapUtils.js',array('isolated-slider'));
wp_enqueue_script('smart-donations-bootstrap-js',SMART_DONATIONS_PLUGIN_URL.'js/bootstrap/bootstrap.min.js',array('isolated-slider'));
wp_enqueue_script('smart-donations-spin-js',SMART_DONATIONS_PLUGIN_URL.'js/bootstrap/spin.min.js');
wp_enqueue_script('smart-donations-ladda-js',SMART_DONATIONS_PLUGIN_URL.'js/bootstrap/ladda.min.js',array('smart-donations-spin-js'));

?>
<div class="bootstrap-wrapper">
<h1 style="display: inline-block"></h1>
<div id="RNNotifications"></div>
<button style="margin-left: 530px;width:100px;cursor: hand;cursor: pointer;" class="btn btn-success ladda-button" id="smartDonationsSaveButton"  data-style="expand-left" onclick="return false;" >
	<span class="glyphicon glyphicon-floppy-disk"></span><span class="ladda-label">Save</span>
</button>
<hr/>

<style type="text/css">
	#wpfooter{
		display: none;
	}
</style>


<div class="category form-horizontal" id='smart_donations_general_options'>
    <div id="rednaoSmartDonaitions">

        <input type="hidden" name="progress_id" id="smartDonationsProgressId" value=""/>
		<div class='form-group'>
			<label class='control-label col-xs-1'>Name</label>
			<div class='col-xs-2'><input type="text" name="progress_name" class="form-control" id="tb_progress_name"/></div>
			<span class="description" style="margin-bottom:5px;"> *The name of the progress indicator, this name is displayed in the progress list</span>
		</div>
		<div class="form-group">
			<label class="control-label col-xs-1">Campaign</label>
			<div class='col-xs-2'>
				<select name="campaign_id" id="select_campaign_id" class="form-control" style="margin-bottom:5px;">
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
	</div>

</div>
</div>

<form id='smart_donations_component_options'  class="donationForm" >


    <!--Item Container--->
    <input type="hidden" id="smartDonationsProgressType" name="smartDonationsProgressType"/>
    <div id="smartdonationsItemsContainer">
        <div id="smartDonationsItemsContainerHeader">
            <span>Select a Progress Indicator Type</span>

        </div>
        <div id="smartDonationsItemsContainerBody">
            <div id="smartDonationsSlideAnimation">
                <div id="smartDonationsItemsList">
                    <div class="smartDonationsItem">
                        <input type="hidden"  value="progressBar"/>
                        <img id="smartDonationsImageClassic" src="<?php echo plugin_dir_url(__FILE__)?>images/ProgressBar.png" alt="" >
                    </div>

                    <div class="smartDonationsItem">
                        <input type="hidden"  value="panels"/>
                        <img id="smartDonationsImageTextBox" src="<?php echo plugin_dir_url(__FILE__)?>images/panels.png" alt="">
                    </div>



                </div>




                <div id="smartDonationsConfiguration">
                    <img id="smartDonationsBackFromConfiguration" src="<?php echo plugin_dir_url(__FILE__)?>images/arrow_back.png" alt="">
                    <span id="smartDonationsItemTitle">Test</span>

<div class="bootstrap-wrapper">
                    <div id="smartDonationsConfigurationFields" class="smartDonationsCustomFields">

                    </div>
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






