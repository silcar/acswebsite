<?php
/**
 * Created by JetBrains PhpStorm.
 * User: edseventeen
 * Date: 3/31/13
 * Time: 8:06 AM
 * To change this template use File | Settings | File Templates.
 */
require_once("smart-donations-helpers.php");
add_action( 'widgets_init', 'rednao_smart_donations_register_donation_wall_widget' );

function rednao_smart_donations_register_donation_wall_widget()
{
    register_widget('rednao_smart_donations_wall_widget');
}

class rednao_smart_donations_wall_widget extends WP_Widget
{
    function rednao_smart_donations_wall_widget()
    {
        $widget_ops = array(
            'classname' => 'rednao_smart_donations_wall_widget', 'description' => __('Create a donation wall')
        );
        parent::__construct('rednao_smart_donations_wall_widget', __('Smart Donations - Donation Wall'),$widget_ops );
    }

    function form($instance)
    {
        $defaults = array( 'campaign_id' => '0', 'number_of_records'=>10 ,'title'=>'Top Donators','currency_sign'=>'$','decimal_sign'=>'.','thousand_separator'=>',');
        $instance = wp_parse_args( (array) $instance, $defaults );
        $campaign_id = $instance['campaign_id'];
        $number_of_records = $instance['number_of_records'];
        $title = $instance['title'];
        $currency_sign = $instance['currency_sign'];
        $decimal_sign = $instance['decimal_sign'];
        $thousand_separator = $instance['thousand_separator'];

        global $wpdb;
        $results =$wpdb->get_results('select campaign_id,name from '.SMART_DONATIONS_CAMPAIGN_TABLE);

        ?>


        <p><?php echo __("Title"); ?>
            <input class="widefat" type="text" name="<?php echo $this->get_field_name("title");?>" value="<?php echo $title?>"/>
        </p>

        <p class="description">
            <?php
                echo __("Select a campaign.");
                echo "<select class='widefat' name='".$this->get_field_name("campaign_id")."'>";
                foreach($results as $result)
                {
                    echo "<option  value='$result->campaign_id'".($campaign_id==$result->campaign_id?" selected='sel'":"" ).">";
                    echo  $result->name;
                    echo "</option>";
                }
                echo "</select>";

            ?>
        </p>

        <p><?php echo __("Currency Sign"); ?>
            <input style='width:50px;text-align:center;' type="text" name="<?php echo $this->get_field_name("currency_sign");?>" value="<?php echo $currency_sign?>"/>
        </p>
        <p><?php echo __("Decimal Sign"); ?>
            <input style='width:50px;text-align:center;' type="text" name="<?php echo $this->get_field_name("decimal_sign");?>" value="<?php echo $decimal_sign?>"/>
        </p>
        <p><?php echo __("Thousand Separator"); ?>
            <input style='width:50px;text-align:center;' type="text" name="<?php echo $this->get_field_name("thousand_separator");?>" value="<?php echo $thousand_separator?>"/>
        </p>
        <?php


        echo "<p style='margin-top:10px'><span> ".__("Display top")."</span> <input style='width:50px;text-align:center;' type=\"text\" name=\"".$this->get_field_name("number_of_records")."\" value=\"$number_of_records\"/> <span>".__("Donators")."</span><p>";


    }

    function update($new_instance, $old_instance)
    {
        $new_instance['title'] =strip_tags($new_instance['title']);
        $new_instance['campaign_id'] =strip_tags($new_instance['campaign_id']);
        $new_instance['number_of_records'] =strip_tags($new_instance['number_of_records']);
        $new_instance['currency_sign'] =strip_tags($new_instance['currency_sign']);
        $new_instance['decimal_sign'] =strip_tags($new_instance['decimal_sign']);
        $new_instance['thousand_separator'] =strip_tags($new_instance['thousand_separator']);

        delete_transient("rednao_smart_donations_wall_".$new_instance['campaign_id']);
        return $new_instance;
    }

    function widget($args, $instance) { // displays the widget
        return rednao_smart_donations_load_wall($instance['campaign_id'],$instance['title'],$instance['number_of_records'],$instance['currency_sign'],$instance['decimal_sign'],$instance['thousand_separator'],false);

    }


}
?>