<?php
/**
 * @var $carousel_settings
 * @var $settings
 * @var $elements
 */

if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'];

// Loop through the elements and do something with them.

if (!empty($elements)) : ?>

    <div
        class="lsow-carousel lsow-container"  <?php foreach ($carousel_settings as $key => $val) : ?>

        <?php if (!empty($val)) : ?>
            data-<?php echo $key . '="' . esc_attr($val) . '"' ?>
        <?php endif ?>

    <?php endforeach; ?>>

        <?php foreach ($elements as $element) : ?>

            <div class="lsow-carousel-item">

                <?php echo do_shortcode(wp_kses_post($element['text'])); ?>

            </div><!--.lsow-carousel-item -->

        <?php endforeach; ?>

    </div> <!-- .lsow-carousel -->

<?php endif; ?>