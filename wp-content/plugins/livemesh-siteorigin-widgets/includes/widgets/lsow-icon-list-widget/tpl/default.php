<?php
/**
 * @var $icon_type
 * @var $icon_list
 * @var $settings
 */

if (!empty($settings['target']))
    $target = 'target="_blank"';
else
    $target = '';

?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<div class="lsow-icon-list lsow-align<?php echo $settings['align']; ?>">

    <?php foreach ($icon_list as $icon_item): ?>

        <?php $icon_type = esc_html($icon_type); ?>

        <?php $icon_title = esc_html($icon_item['title']); ?>

        <?php $icon_url = sow_esc_url($icon_item['href']); ?>

        <div class="lsow-icon-list-item" title="<?php echo $icon_title; ?>">

            <?php if ($icon_type == 'icon_image') : ?>

                <?php if (empty($icon_url)) : ?>

                    <div class="lsow-image-wrapper">

                        <?php echo wp_get_attachment_image($icon_item['icon_image'], 'full', false, array('class' => 'lsow-image full', 'alt' => $icon_title)); ?>

                    </div>

                <?php else : ?>

                    <a class="lsow-image-wrapper" href="<?php echo $icon_url; ?>" <?php echo $target; ?>>

                        <?php echo wp_get_attachment_image($icon_item['icon_image'], 'full', false, array('class' => 'lsow-image full', 'alt' => $icon_title)); ?>

                    </a>

                <?php endif; ?>

            <?php else : ?>

                <?php if (empty($icon_url)) : ?>

                    <div class="lsow-icon-wrapper">

                        <?php echo siteorigin_widget_get_icon($icon_item['icon']); ?>

                    </div>

                <?php else : ?>

                    <a class="lsow-icon-wrapper" href="<?php echo $icon_url; ?>" <?php echo $target; ?>>

                        <?php echo siteorigin_widget_get_icon($icon_item['icon']); ?>

                    </a>

                <?php endif; ?>

            <?php endif; ?>

        </div>

        <?php

    endforeach;

    ?>

</div>