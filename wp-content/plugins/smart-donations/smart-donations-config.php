<?php
/**
 * Created by JetBrains PhpStorm.
 * User: edseventeen
 * Date: 3/29/13
 * Time: 9:29 AM
 * To change this template use File | Settings | File Templates.
 */

global $wpdb;
if(!defined('ABSPATH'))
    die('Forbidden');

define('SMART_DONATIONS_PLUGIN_NAME',dirname(plugin_basename(__FILE__)));
define('SMART_DONATIONS_DIR',WP_PLUGIN_DIR.'/'.SMART_DONATIONS_PLUGIN_NAME);
define('SMART_DONATIONS_TABLE_NAME',$wpdb->prefix . "smart_donations_donation_item");
define('SMART_DONATIONS_TRANSACTION_TABLE',$wpdb->prefix . "smart_donations_transaction_table");
define('SMART_DONATIONS_CAMPAIGN_TABLE',$wpdb->prefix . "smart_donations_campaign_table");
define('SMART_DONATIONS_PROGRESS_TABLE',$wpdb->prefix . "smart_donations_progress_table");
define('SMART_DONATIONS_LATEST_DB_VERSION',11);
define('REDNAO_URL',"http://rednao.com/");
define('SMART_DONATIONS_VERSION',11);
define('SMART_DONATIONS_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SMART_DONATIONS_SANDBOX','n');
define('SMART_DONATIONS_REQUIRED_ROLE','manage_options')
?>