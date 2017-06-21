<?php
/**
 * @var $settings
 * @var $style
 * @var $services
 */

?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<?php $column_style = lsow_get_column_class(intval($settings['per_line'])); ?>

<div class="lsow-services lsow-<?php echo $style; ?> lsow-container">

    <?php foreach ($services as $service): ?>

        <?php $icon_type = esc_html($service['icon_type']); ?>

        <div class="lsow-service-wrapper <?php echo $column_style; ?>">

            <div class="lsow-service">

                <?php if ($icon_type == 'icon_image') : ?>

                    <div class="lsow-image-wrapper">

                        <?php echo wp_get_attachment_image($service['icon_image'], 'full', false, array('class' => 'lsow-image full')); ?>

                    </div>

                <?php else : ?>

                    <div class="lsow-icon-wrapper">

                        <?php echo siteorigin_widget_get_icon($service['icon']); ?>

                    </div>

                <?php endif; ?>

                <div class="lsow-service-text">

                    <h3 class="lsow-title"><?php echo esc_html($service['title']) ?></h3>

                    <div class="lsow-service-details"><?php echo wp_kses_post($service['excerpt']) ?></div>

                </div>

            </div>

        </div>

    <?php

    endforeach;

    ?>

</div>