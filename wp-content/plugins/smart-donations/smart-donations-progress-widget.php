<?php
/**
 * Created by JetBrains PhpStorm.
 * User: edseventeen
 * Date: 3/31/13
 * Time: 8:06 AM
 * To change this template use File | Settings | File Templates.
 */
require_once("smart-donations-helpers.php");
add_action( 'widgets_init', 'rednao_smart_donations_register_progress_widget' );

function rednao_smart_donations_register_progress_widget()
{
    register_widget('rednao_smart_donations_progress_widget');
}

class rednao_smart_donations_progress_widget extends WP_Widget
{
    function rednao_smart_donations_progress_widget()
    {
        $widget_ops = array(
            'classname' => 'rednao_smart_donations_progress_widget', 'description' => 'Let you insert an progress indicator in any area'
        );
        parent::__construct('rednao_smart_donations_progress_widget', 'Smart Donations - Progress Indicator',$widget_ops );
    }

    function form($instance)
    {
        $defaults = array( 'progress_id' => '0','title'=>'' );
        $instance = wp_parse_args( (array) $instance, $defaults );
        $id = $instance['progress_id'];
        $title = $instance['title'];

        global $wpdb;
        $results =$wpdb->get_results('select progress_id,progress_name from '.SMART_DONATIONS_PROGRESS_TABLE);

        ?>

        <p class="description">
            Select a progress indicator.
        </p>
        <p>Title
            <input class="widefat" type="text" name="<?php echo $this->get_field_name("title");?>" value="<?php echo $title?>"/>
        </p>

        <?php
        echo "<select class='widefat' name='".$this->get_field_name("progress_id")."'>";
        foreach($results as $result)
        {
            echo "<option  value='$result->progress_id'".($id==$result->progress_id?" selected='sel'":"" ).">";
            echo  $result->progress_name;
            echo "</option>";
        }
        echo "</select>";
    }

    function update($new_instance, $old_instance)
    {
        $new_instance['title'] =strip_tags($new_instance['title']);
        $new_instance['progress_id'] =strip_tags($new_instance['progress_id']);

        delete_transient("rednao_smart_donations_progress_".$new_instance['progress_id']);
        return $new_instance;
    }

    function widget($args, $instance) { // displays the widget
        $id=$instance['progress_id'];
        return rednao_smart_donations_load_progress($id,$instance['title'],false);
    }


}
?>