<?php
/**
 * Created by JetBrains PhpStorm.
 * User: edseventeen
 * Date: 6/13/13
 * Time: 8:04 PM
 * To change this template use File | Settings | File Templates.
 */
wp_enqueue_script('jquery');
wp_enqueue_script('isolated-slider',plugin_dir_url(__FILE__).'js/rednao-isolated-jq.js');
wp_enqueue_script('exCanvas',plugin_dir_url(__FILE__).'js/excanvas.min.js',array('isolated-slider'));
wp_enqueue_script('jqPlot',plugin_dir_url(__FILE__).'js/jquery.jqplot.min.js',array('exCanvas'));
wp_enqueue_script('jqHighlighter',plugin_dir_url(__FILE__).'js/jqplot.highlighter.js',array('jqPlot'));
wp_enqueue_script('jqCursor',plugin_dir_url(__FILE__).'js/jqplot.cursor.min.js',array('jqHighlighter'));
wp_enqueue_script('jqDateAxis',plugin_dir_url(__FILE__).'js/jqplot.dateAxisRenderer.min.js',array('jqHighlighter'));
wp_enqueue_script('jqCanvasAxis',plugin_dir_url(__FILE__).'js/jqplot.canvasAxisTickRenderer.min.js',array('jqCursor'));
wp_enqueue_script('jqPointLabels',plugin_dir_url(__FILE__).'js/jqplot.pointLabels.min.js',array('jqCanvasAxis'));
wp_enqueue_script('smart-donations-analytics',plugin_dir_url(__FILE__).'js/smart-donations-analytics.js',array('jqPointLabels'));


wp_enqueue_script('jqGridlocale',plugin_dir_url(__FILE__).'js/grid.locale-en.js',array('isolated-slider'));
wp_enqueue_script('jqGrid',plugin_dir_url(__FILE__).'js/jquery.jqGrid.min.js',array('jqGridlocale'));


wp_enqueue_style('jqgrid',plugin_dir_url(__FILE__).'css/ui.jqgrid.css');
wp_enqueue_style('jqplot',plugin_dir_url(__FILE__).'css/jquery.jqplot.css');
wp_enqueue_style('smart-donations-Slider',plugin_dir_url(__FILE__).'css/smartDonationsSlider/jquery-ui-1.10.2.custom.min.css');




wp_enqueue_style('smart-donations-bootstrap-theme',SMART_DONATIONS_PLUGIN_URL.'css/bootstrap/bootstrap-theme.css');
wp_enqueue_style('smart-donations-bootstrap',SMART_DONATIONS_PLUGIN_URL.'css/bootstrap/bootstrap-scopped.css');
wp_enqueue_style('smart-donations-ladda',SMART_DONATIONS_PLUGIN_URL.'css/bootstrap/ladda-themeless.min.css');



wp_enqueue_script('smart-donations-bootstrap-theme',SMART_DONATIONS_PLUGIN_URL.'js/bootstrap/bootstrapUtils.js',array('isolated-slider'));
wp_enqueue_script('smart-donations-bootstrap-js',SMART_DONATIONS_PLUGIN_URL.'js/bootstrap/bootstrap.min.js',array('jquery'));
wp_enqueue_script('smart-donations-spin-js',SMART_DONATIONS_PLUGIN_URL.'js/bootstrap/spin.min.js');
wp_enqueue_script('smart-donations-ladda-js',SMART_DONATIONS_PLUGIN_URL.'js/bootstrap/ladda.min.js',array('smart-donations-spin-js'));



if(!defined('ABSPATH'))
    die('Forbidden');

require_once('smart-donations-messages.php');
?>


<div class="bootstrap-wrapper">
<h1 >Analytics</h1>

<hr style="padding: 0;margin:0;"/>

<div id="rnNotifications"></div>


<div id="smartDonationRadio" class="smartDonationsSlider" style="margin-bottom: 20px;">
    <strong >Start Date</strong>
    <input type="text" class="datePicker smartDonationsSlider" id="dpStartDate"/>
    <strong style="margin-left: 15px">End Date</strong>
    <input type="text" class="datePicker smartDonationsSlider" id="dpEndDate"/>
    <strong style="margin-left: 15px" >Campaign</strong>
    <select id="cbCampaign">
        <option value="-1" selected="selected">All</option>
        <option value="0" selected="selected">Default</option>
        <?php
        global $wpdb;
        $results=$wpdb->get_results("select campaign_id,name from ".SMART_DONATIONS_CAMPAIGN_TABLE);

        foreach($results as $result)
        {
            echo "<option value='$result->campaign_id' >$result->name</option>";
        }

        ?>
    </select>

    <script type="text/javascript" language="javascript">
        var RedNaoCampaignList="";
        <?php
            echo "RedNaoCampaignList='0:default";
            foreach($results as $result)
            {

                echo ";$result->campaign_id:$result->name";
            }
            echo "'";
        ?>
    </script>

    <strong style="margin-left: 15px" >Display Format</strong>
    <select id="cbDisplayType">
        <option value="d" >Daily</option>
        <option value="w" selected="selected">Weekly</option>
        <option value="m">Monthly</option>
        <option value="y">Yearly</option>
    </select>

	<button class="btn btn-success ladda-button" id="btnExecute"  data-style="expand-left" onclick="return false;" >
		<span class="glyphicon glyphicon-search"></span><span class="ladda-label">Execute</span>
	</button>



</div>
</div>
<div style="width:80%;overflow-x: scroll;padding:25px;">
<div id="Chart"></div>
</div>


<div>
    <div class="smartDonationsSlider">
    <table id='grid' class="ui-jqdialogasdf" style="width:100%"></table><div id='pager'></div>
    </div>