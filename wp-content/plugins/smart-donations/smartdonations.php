<?php
/**
 * Plugin Name: Smart Donations
 * Plugin URI: http://rednao.com/smart-donations/
 * Description: Place diferent form of donations on your blog...
 * Author: RedNao
 * Author URI: http://rednao.com
 * Version: 4.0.12
 * Text Domain: SmartDonations
 * Domain Path: /languages/
 * Network: true
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0
 * Slug: smartdonations
 */

/**
 *	Copyright (C) 2012-2013 RedNao (email: contactus@rednao.com)
 *
 *	This program is free software; you can redistribute it and/or
 *	modify it under the terms of the GNU General Public License
 *	as published by the Free Software Foundation; either version 2
 *	of the License, or (at your option) any later version.
 *
 *	This program is distributed in the hope that it will be useful,
 *	but WITHOUT ANY WARRANTY; without even the implied warranty of
 *	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *	GNU General Public License for more details.
 *
 *	You should have received a copy of the GNU General Public License
 *	along with this program; if not, write to the Free Software
 *	Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Thanks to:
 * Jakub Stacho (http://www.iconfinder.com/iconsets/checkout-icons#readme)
 * Eggib (http://openclipart.org/detail/174878/)
 * Aha-Soft (http://www.iconfinder.com/iconsets/24x24-free-pixel-icons#readme)
 * Kevin Liew (http://www.queness.com/post/106/jquery-tabbed-interfacetabbed-structure-menu-tutorial)
 * Marcis Gasuns (http://led24.de/iconset/)
 */

require_once('smart-donations-config.php');
require_once('smart-donations-ajax.php');
require_once('smart-donations-widget.php');
require_once('smart-donations-progress-widget.php');


register_activation_hook(__FILE__,'rednao_smart_donations_plugin_was_activated');
add_action('admin_init','rednao_smart_donations_plugin_was_activated');
add_shortcode('sdonations','rednao_smart_donations_short_code');
add_shortcode('sdprogress','rednao_smart_donations_progress_short_code');
add_shortcode('sddonwall','rednao_smart_donations_wall_short_code');

add_action('init', 'rednao_smart_donations_init');
add_action('admin_menu','rednao_smart_donations_create_menu');
add_action( 'wp_ajax_rednao_smart_donations_save', 'rednao_smart_donations_save' );
add_action( 'wp_ajax_rednao_smart_donations_list', 'rednao_smart_donations_list' );
add_action( 'wp_ajax_rednao_smart_donations_add_campaign', 'rednao_smart_donations_add_campaign' );
add_action( 'wp_ajax_rednao_smart_donations_edit_campaign', 'rednao_smart_donations_edit_campaign' );
add_action( 'wp_ajax_rednao_smart_donations_save_progress_bar','rednao_smart_donations_save_progress_bar');
add_action( 'wp_ajax_rednao_smart_donations_execute_analytics','rednao_smart_donations_execute_analytics');
add_action( 'wp_ajax_rednao_smart_donations_execute_analytics_list','rednao_smart_donations_execute_analytics_list');
add_action( 'wp_ajax_rednao_smart_donations_execute_analytics_op','rednao_smart_donations_execute_analytics_op');
add_action( 'wp_ajax_rednao_smart_progress_donations_list','rednao_smart_progress_donations_list');
add_action( 'wp_ajax_rednao_smart_donations_save_form_values','rednao_smart_donations_save_form_values');
add_action( 'wp_ajax_nopriv_rednao_smart_donations_save_form_values','rednao_smart_donations_save_form_values');
add_action( 'wp_ajax_rednao_smart_donations_campaign_list','rednao_smart_donations_campaign_list');

add_action('http_request_args', 'no_ssl_http_request_args', 10, 2);
function no_ssl_http_request_args($args, $url) {
    $args['sslverify'] = false;
    return $args;
}



function rednao_smart_donations_create_menu(){
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('query-ui-dialog');
    add_menu_page('Smart Donations','Smart Donations',SMART_DONATIONS_REQUIRED_ROLE,'smart_donations_menu','rednao_smartdonations_donation_buttons',plugin_dir_url(__FILE__).'images/smartDonationsIcon.png');
    add_submenu_page('smart_donations_menu','Campaigns','Campaigns',SMART_DONATIONS_REQUIRED_ROLE,__FILE__.'campaigns', 'rednao_smart_donations_campaigns');
    add_submenu_page('smart_donations_menu','Progress Indicators','Progress Indicators',SMART_DONATIONS_REQUIRED_ROLE,__FILE__.'progress_indicators', 'rednao_smart_donations_progress_indicators');
    add_submenu_page('smart_donations_menu','Analytics','Analytics',SMART_DONATIONS_REQUIRED_ROLE,__FILE__.'analytics', 'rednao_smart_donations_analytics');
    add_submenu_page('smart_donations_menu','Smart Donations - Wish List','Wish List/Support',SMART_DONATIONS_REQUIRED_ROLE,__FILE__.'wishlist', 'rednao_smart_donations_wish_list');
    add_submenu_page('smart_donations_menu','Settings','Settings',SMART_DONATIONS_REQUIRED_ROLE,__FILE__.'settings', 'rednao_smart_donations_settings');


	do_action('add_smart_donations_screens');
}

function rednao_smart_donations_init()
{
    if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') ) {
        return;
    }

    if ( get_user_option('rich_editing') == 'true') {
        add_filter( 'mce_external_plugins', 'rednao_smart_donations_add_plugin' );
        add_filter( 'mce_buttons', 'rednao_smart_donations_register_button' );
    }
}

function rednao_smart_donations_add_plugin($plugin_array)
{
    if(smart_donations_check_license_with_options($error)||$error!=null)
        echo '<script type="application/javascript">var smartDonationsLc=1;</script>';
    else
        echo '<script type="application/javascript">var smartDonationsLc=0;</script>';

    wp_enqueue_script('isolated-slider',plugin_dir_url(__FILE__).'js/rednao-isolated-jq.js');
    wp_enqueue_style('smart-donations-Slider',plugin_dir_url(__FILE__).'css/smartDonationsSlider/jquery-ui-1.10.2.custom.min.css');
    $plugin_array['rednao_smart_donations_button']=plugin_dir_url(__FILE__).'js/smartDonationsShortCodeButton.js';
    return $plugin_array;
}

function rednao_smart_donations_register_button($buttons)
{
    $buttons[]="rednao_smart_donations_button";
    return $buttons;
}


function rednao_smart_donations_plugin_was_activated()
{
    $dbversion=get_option("REDNAO_SMART_DONATIONS_DB_VERSION");

    global $wpdb;

    if(!$dbversion|| $dbversion<SMART_DONATIONS_LATEST_DB_VERSION )
    {
        delete_transient("smart_donations_check_again");

        require_once(ABSPATH.'wp-admin/includes/upgrade.php');

        $sql="CREATE TABLE ".SMART_DONATIONS_TABLE_NAME." (
        donation_id int AUTO_INCREMENT,
        donation_name VARCHAR(200) NOT NULL,
        email VARCHAR(200) NOT NULL,
        donation_type VARCHAR(20) NOT NULL,
        returning_url VARCHAR(2000),
        options TEXT NOT NULL,
        donation_provider VARCHAR(20),
        styles TEXT,
        PRIMARY KEY  (donation_id)
        );";
        dbDelta($sql);

        $wpdb->query("ALTER TABLE ".SMART_DONATIONS_TRANSACTION_TABLE." DROP INDEX idx_payer_email");
        $wpdb->query("ALTER TABLE ".SMART_DONATIONS_TRANSACTION_TABLE." DROP INDEX idx_campaign_id");
        $sql="CREATE TABLE ".SMART_DONATIONS_TRANSACTION_TABLE." (
        transaction_id double AUTO_INCREMENT,
        txn_id VARCHAR(200),
        payer_email VARCHAR(200),
        first_name VARCHAR(50),
        last_name VARCHAR(200),
        mc_fee float NOT NULL,
        mc_gross VARCHAR(20),
        date datetime,
        additional_fields TEXT,
        status char(1),
        campaign_id int,
        form_information MEDIUMTEXT,
        reference_id VARCHAR(200),
        subscr_id VARCHAR(200),
        PRIMARY KEY  (transaction_id),
        KEY idx_payer_email(payer_email),
        is_anonymous tinyint,
        KEY idx_campaign_id(campaign_id)
        );";
        dbDelta($sql);


        $sql="CREATE TABLE ".SMART_DONATIONS_CAMPAIGN_TABLE." (
        campaign_id double AUTO_INCREMENT,
        name VARCHAR(200) NOT NULL,
        description VARCHAR(200),
        goal double ,
        thank_you_email TEXT,
        email_subject VARCHAR(200),
        email_from VARCHAR(200),
        PRIMARY KEY  (campaign_id)
        );";
        dbDelta($sql);



        $sql="CREATE TABLE ".SMART_DONATIONS_PROGRESS_TABLE." (
        progress_id int AUTO_INCREMENT,
        progress_name VARCHAR(200) NOT NULL,
        campaign_id VARCHAR(200) NOT NULL,
        progress_type VARCHAR(20) NOT NULL,
        options TEXT NOT NULL,
        styles TEXT,
        PRIMARY KEY  (progress_id)
        );";
        dbDelta($sql);

        update_option("REDNAO_SMART_DONATIONS_DB_VERSION",SMART_DONATIONS_LATEST_DB_VERSION);
    }
}

function rednao_smart_donations_short_code($attr,$content)
{
    return rednao_smart_donations_load_donation($content,null,true);
}


function rednao_smart_donations_progress_short_code($attr,$content)
{
    return rednao_smart_donations_load_progress($content,null,true);
}

function rednao_smart_donations_wall_short_code($attr,$content)
{
    return rednao_smart_donations_load_wall($content,"",$attr["numberofdonors"],$attr["currencysign"],$attr["decimalsign"],$attr["thousandseparator"],true);
}

function rednao_smart_donations_settings()
{
    include(SMART_DONATIONS_DIR.'/smartdonations-settings.php');
}

function rednao_smartdonations_donation_buttons()
{
    include(SMART_DONATIONS_DIR.'/smart-donations-list.php');
}

function rednao_smart_donations_campaigns()
{
    include(SMART_DONATIONS_DIR.'/smart-donations-campaigns.php');
}

function rednao_smart_donations_progress_indicators()
{
    require_once('smart-donations-license-helpers.php');
    if(smart_donations_check_license_with_options($error)||$error!=null)
        include(SMART_DONATIONS_DIR.'/smart-donations-progress-indicators.php');
    else
        include(SMART_DONATIONS_DIR.'/smart-donations-progress-pro.php');


}

function rednao_smart_donations_analytics()
{

    require_once('smart-donations-license-helpers.php');
    if(smart_donations_check_license_with_options($error)||$error!=null)
        include(SMART_DONATIONS_DIR.'/smart-donations-analytics.php');
    else
        include(SMART_DONATIONS_DIR.'/smart-donations-analytics-pro.php');



}



function rednao_smart_donations_wish_list()
{
    include(SMART_DONATIONS_DIR.'/smart-donations-wishlist.php');
}

require_once('smart-donations-license-helpers.php');
if(smart_donations_check_license_with_options($error)||$error!=null)
{
    require_once('smart-donations-wall-widget.php');
}



add_filter('query_vars','smart_donations_add_trigger');
function smart_donations_add_trigger($vars) {
	$vars[] = 'smart_donation_ipn_trigger';
	return $vars;
}

add_action('template_redirect', 'smart_donations_check_if_ipn');
function smart_donations_check_if_ipn()
{
	$val=get_query_var('sd_ipn_trigger')?get_query_var('sd_ipn_trigger'):"";
	if($val==""&&isset($_GET["sd_ipn_trigger"]))
		$val=$_GET["sd_ipn_trigger"];
	if(intval($val)==1) {
		require_once SMART_DONATIONS_DIR.'/ipn/rednao_paypal_ipn.php';
		exit;
	}
}