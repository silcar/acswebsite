<?php
/**
 * @var $piecharts
 */

?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<?php $column_style = lsow_get_column_class(intval($settings['per_line'])); ?>

<?php

$bar_color = ' data-bar-color="' . esc_attr($settings['bar_color']) . '"';
$track_color = ' data-track-color="' . esc_attr($settings['track_color']) . '"';

?>

<div class="lsow-piecharts lsow-container">

    <?php foreach ($piecharts as $piechart): ?>

        <div class="lsow-piechart <?php echo $column_style; ?>">

            <div class="lsow-percentage" <?php echo $bar_color; ?> <?php echo $track_color; ?>
                 data-percent="<?php echo intval($piechart['percentage']); ?>">

                <span><?php echo intval($piechart['percentage']); ?><sup>%</sup></span>

            </div>

            <div class="lsow-label"><?php echo esc_html($piechart['stats_title']); ?></div>

        </div>

    <?php

    endforeach;

    ?>

</div>