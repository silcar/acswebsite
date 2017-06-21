<?php
/**
 * @var $odometers
 */

?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<?php $column_style = lsow_get_column_class(intval($settings['per_line'])); ?>

<div class="lsow-odometers lsow-container">

    <?php foreach ($odometers as $odometer): ?>

        <?php

        $prefix = (!empty ($odometer['prefix'])) ? '<span class="prefix">' . $odometer['prefix'] . '</span>' : '';
        $suffix = (!empty ($odometer['suffix'])) ? '<span class="suffix">' . $odometer['suffix'] . '</span>' : '';

        ?>

        <div class="lsow-odometer <?php echo $column_style; ?>">

            <?php echo (!empty ($odometer['prefix'])) ? '<span class="lsow-prefix">' . $odometer['prefix'] . '</span>' : ''; ?>

            <div class="lsow-number odometer" data-stop="<?php echo intval($odometer['stop_value']); ?>">

                <?php echo intval($odometer['start_value']); ?>

            </div>

            <?php echo (!empty ($odometer['suffix'])) ? '<span class="lsow-suffix">' . $odometer['suffix'] . '</span>' : ''; ?>

            <?php $icon_type = esc_html($odometer['icon_type']); ?>

            <?php if ($icon_type == 'icon_image') : ?>

                <?php $icon_html = '<span class="lsow-image-wrapper">' . wp_get_attachment_image($odometer['icon_image'], 'full', false, array('class' => 'lsow-image full')) . '</span>'; ?>

            <?php else : ?>

                <?php $icon_html = '<span class="lsow-icon-wrapper">' . siteorigin_widget_get_icon($odometer['icon']) . '</span>'; ?>

            <?php endif; ?>

            <div class="lsow-stats-title-wrap">

                <div class="lsow-stats-title"><?php echo $icon_html . esc_html($odometer['stats_title']); ?></div>

            </div>

        </div>

    <?php

    endforeach;

    ?>

</div>