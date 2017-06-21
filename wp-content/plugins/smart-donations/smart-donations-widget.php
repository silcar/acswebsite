<?php
/**
 * Created by JetBrains PhpStorm.
 * User: edseventeen
 * Date: 3/31/13
 * Time: 8:06 AM
 * To change this template use File | Settings | File Templates.
 */
require_once("smart-donations-helpers.php");
add_action( 'widgets_init', 'rednao_smart_donations_register_widget' );

function rednao_smart_donations_register_widget()
{
    register_widget('rednao_smart_donations_widget');
}

class rednao_smart_donations_widget extends WP_Widget
{
    function rednao_smart_donations_widget()
    {
        $widget_ops = array(
            'classname' => 'rednao_smart_donations_widget', 'description' => 'Let you insert an smart donation in any area'
        );
        parent::__construct('rednao_smart_donations_widget', 'Smart Donations - Donation Button',$widget_ops );
    }

    function form($instance)
    {
        $defaults = array( 'donation_id' => '0','title'=>'' );
        $instance = wp_parse_args( (array) $instance, $defaults );
        $id = $instance['donation_id'];
        $title=$instance['title'];

        global $wpdb;
        $results =$wpdb->get_results('select donation_id,donation_name from '.SMART_DONATIONS_TABLE_NAME);

        ?>

            <p class="description">
                Select a donation.
            </p>
            <p>Title
                <input class="widefat" type="text" name="<?php echo $this->get_field_name("title");?>" value="<?php echo $title;?>"/>
            </p>

        <?php
        echo "<select class='widefat' name='".$this->get_field_name("donation_id")."'>";
        foreach($results as $result)
        {
            echo "<option  value='$result->donation_id'".($id==$result->donation_id?" selected='sel'":"" ).">";
            echo  $result->donation_name;
            echo "</option>";
        }
        echo "</select>";
    }

    function update($new_instance, $old_instance)
    {
        $new_instance['title'] =strip_tags($new_instance['title']);
        $new_instance['donation_id'] =strip_tags($new_instance['donation_id']);

        delete_transient("rednao_smart_donations_donation_".$new_instance['donation_id']);
        return $new_instance;
    }

    function widget($args, $instance) { // displays the widget
        $id=$instance['donation_id'];
        return rednao_smart_donations_load_donation($id,$instance['title'],false);
    }


}
?>