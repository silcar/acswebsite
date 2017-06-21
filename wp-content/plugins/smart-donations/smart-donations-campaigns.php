<?php

if(!defined('ABSPATH'))
    die('Forbidden');

wp_enqueue_style('smart-donations-bootstrap-theme',SMART_DONATIONS_PLUGIN_URL.'css/bootstrap/bootstrap-theme.css');
wp_enqueue_style('smart-donations-bootstrap',SMART_DONATIONS_PLUGIN_URL.'css/bootstrap/bootstrap-scopped.css');

wp_enqueue_script('jquery');
wp_enqueue_script('isolated-slider',plugin_dir_url(__FILE__).'js/rednao-isolated-jq.js',array('jquery'));
wp_enqueue_script('campaigns',plugin_dir_url(__FILE__).'js/smart-donations-campaigns.js',array('isolated-slider'));
wp_enqueue_style('smart-donations-main-style',plugin_dir_url(__FILE__).'css/mainStyle.css');
wp_enqueue_style('smart-donations-Slider',plugin_dir_url(__FILE__).'css/smartDonationsSlider/jquery-ui-1.10.2.custom.min.css');
wp_enqueue_style('smart-donations-ladda',SMART_DONATIONS_PLUGIN_URL.'css/bootstrap/ladda-themeless.min.css');

wp_enqueue_script('smart-donations-bootstrap-theme',SMART_DONATIONS_PLUGIN_URL.'js/bootstrap/bootstrapUtils.js',array('isolated-slider'));
wp_enqueue_script('smart-donations-bootstrap-js',SMART_DONATIONS_PLUGIN_URL.'js/bootstrap/bootstrap.min.js',array('isolated-slider'));
wp_enqueue_script('smart-donations-spin-js',SMART_DONATIONS_PLUGIN_URL.'js/bootstrap/spin.min.js');
wp_enqueue_script('smart-donations-ladda-js',SMART_DONATIONS_PLUGIN_URL.'js/bootstrap/ladda.min.js',array('smart-donations-spin-js'));

require_once('smart-donations-messages.php');


echo "<div class='bootstrap-wrapper'>";
?>



<!-- Modal -->
<div class="modal fade" id="campaignModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 750px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="myModalTitle">Modal title</h4>
			</div>
			<div class="modal-body" style="padding-top: 0px;">
				<div id="rnNotification"></div>
				<div  class='form-horizontal' style='padding:30px; padding-top:5px;'>

					<div class='form-group'>
						<label class='control-label col-xs-3'>Name</label>
						<div class='col-xs-6'><input type="text" id="smart_donations_campaign_name" name="name" class="smartDonationsConfigurationFields form-control"></div>
					</div>


					<div class='form-group'>
						<label class='control-label col-xs-3'>Description</label>
						<div class='col-xs-6'><input type="text" id="smart_donations_campaign_description" name="description" class="smartDonationsConfigurationFields form-control"></div>
					</div>


					<div class='form-group'>
						<label class='control-label col-xs-3'>Goal</label>
						<div class='col-xs-6'><input type="text" name="goal" id="smart_donations_campaign_goal" class="smartDonationsConfigurationFields smartDonationsNumericField form-control"></div>
					</div>


					<div class='form-group'>
						<label class='control-label col-xs-3'>Send thank you email</label>
						<div class='col-xs-6'><input type="checkbox" id="smartDonationsSendThankYouEmail" /></div>
					</div>


					<div class='form-group'>
						<label class='control-label col-xs-3'>Email From:</label>
						<div class='col-xs-6'><input type="text"  class="form-control"  id="smartDonationsEmailFrom" name="email_subject" disabled="disabled"/></div>
					</div>

					<div class='form-group'>
						<label class='control-label col-xs-3'>Email Subject:</label>
						<div class='col-xs-6'><input type="text"   id="smartDonationsEmailSubject" name="email_subject"  class="form-control" disabled="disabled"/></div>
					</div>

					<div class='form-group'>
						<label class='control-label col-xs-3'>Email Text:</label>
						<div class='col-xs-6'><textarea  class="form-control"  id="smartDonationsThankYouEmail" name="thank_you_email" style="height:200px;width: 500px;background-color: #ddd" disabled="disabled"></textarea></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-success" id="campaignSaveButton"  data-style="expand-left"><span class="glyphicon glyphicon-floppy-disk"></span><span> Save changes</span></button>
			</div>
		</div>
	</div>
</div>


<?php

if (isset($_GET['action'])) {
    $action=$_GET['action'];
}else
    $action="";

if($action!="edit")
{

	echo "<h1>Campaigns</h1>";
	echo sprintf(' <a href="?page=%s&action=%s" id="sDonationsAddNew" class="btn btn-default btn-success" ><span class="glyphicon glyphicon-plus" ></span>Add New</a>',$_REQUEST['page'],'add');

}
echo "</div>";

if (isset($_GET['id'])) {
    $campaign_id=$_GET['id'];
}else
    $campaign_id="";


if($action!=null&&$campaign_id!=null)
{
    global $wpdb;

    if($action==="delete")
        $wpdb->query($wpdb->prepare("delete from ".SMART_DONATIONS_CAMPAIGN_TABLE." WHERE campaign_id=%d",$campaign_id));

}


class Donations extends WP_List_Table
{
    function get_columns()
    {
        return array(
            'name'=>'Name',
            'description'=>'Description',
            'goal'=>'Goal',
            'campaign_id'=>'Campaign Id'
        );
    }

    function prepare_items()
    {
        $this->_column_headers=array($this->get_columns(),array('campaign_id'),$this->get_sortable_columns());
        global $wpdb;
        $this->items=$result=$wpdb->get_results("SELECT campaign_id,name,description,goal,thank_you_email,email_subject,email_from FROM ".SMART_DONATIONS_CAMPAIGN_TABLE);

        if(count($this->items)>0)
        {

            $json= "<script> var smartDonationsCampaignArray=[";
            foreach ($this->items as $item) {
                $json.='{"campaign_id":"'.urldecode($item->campaign_id).'",';
                $json.='"description":"'.urldecode($item->description).'",';
                $json.='"goal":"'.urldecode($item->goal).'",';
                $json.='"thank_you_email":"'.str_replace("\r","", str_replace("\n","\\n",urldecode($item->thank_you_email))).'",';
                $json.='"email_subject":"'.urldecode($item->email_subject).'",';
                $json.='"email_from":"'.urldecode($item->email_from).'",';
                $json.='"name":"'.urldecode($item->name).'"},';
            }
            $json=substr($json,0,-1);
            $json.= "];</script>";
            echo $json;
        }


    }

    function get_sortable_columns()
    {

    }

    function column_default($item, $column_name)
    {
        return $item->$column_name;
    }

    function column_name($item) {
        $actions = array(
            'edit'      => sprintf("<a href='javascript:smartDonationsEditCampaign($item->campaign_id)'>Edit</a>"),
            'delete'    => sprintf('<a href="?page=%s&id=%s&action=%s">Delete</a>',$_REQUEST['page'],$item->campaign_id,'delete'),
        );

        return sprintf('%1$s %2$s', $item->name, $this->row_actions($actions) );
    }
}

$donationList=new Donations();
$donationList->prepare_items();
$donationList->display();

?>


<!--
<div id="smart-donations-add-new-campaign-panel" title="Create campaign">
    <table>
        <tr>
            <td>Name</td>
            <td><input type="text" id="smart_donations_campaign_name" name="name" class="smartDonationsConfigurationFields"></td>
        </tr>

        <tr>
            <td>Description</td>
            <td><input type="text" id="smart_donations_campaign_description" name="description" class="smartDonationsConfigurationFields"></td>
        </tr>

        <tr>
            <td>Goal</td>
            <td><input type="text" name="goal" id="smart_donations_campaign_goal" class="smartDonationsConfigurationFields smartDonationsNumericField"></td>
        </tr>



        <tr><td > <span>Send thank you email</span> </td><td><input type="checkbox" id="smartDonationsSendThankYouEmail" /></td></tr>

        <tr><td colspan="2" style="padding-top:30px;"><span >Email From:</span></td></tr>
        <tr><td colspan="2"><input type="text"   id="smartDonationsEmailFrom" name="email_subject" style="width: 400px;background-color: #ddd" disabled="disabled"></textarea> </td></tr>
        <tr><td colspan="2" ><span >Email Subject:</span></td></tr>
        <tr><td colspan="2"><input type="text"   id="smartDonationsEmailSubject" name="email_subject" style="width: 400px;background-color: #ddd" disabled="disabled"></textarea> </td></tr>
        <tr><td colspan="2" style="padding-top:10px;"><span >Email Text:</span></td></tr>
        <tr><td colspan="2"><textarea   id="smartDonationsThankYouEmail" name="thank_you_email" style="height:200px;width: 500px;background-color: #ddd" disabled="disabled"></textarea> </td></tr>
        <tr>
            <td colspan="2"><div style="text-align: right"><button id="campaignSaveButton">Save</button></div></td>
        </tr>
    </table>
</div>-->