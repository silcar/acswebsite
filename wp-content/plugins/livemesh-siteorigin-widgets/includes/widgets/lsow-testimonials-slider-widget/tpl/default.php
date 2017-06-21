<?php
/**
 * @var $settings
 * @var $testimonials
 */

?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<div class="lsow-testimonials-slider lsow-flexslider lsow-container" <?php foreach ($settings as $key => $val) : ?>
    <?php if (!empty($val)) : ?>
        data-<?php echo $key . '="' . esc_attr($val) . '"' ?>
    <?php endif ?>
<?php endforeach; ?>>

    <div class="lsow-slides">

        <?php foreach ($testimonials as $testimonial) : ?>

            <div class="lsow-slide lsow-testimonial-wrapper">

                <div class="lsow-testimonial">

                    <div class="lsow-testimonial-text">

                        <i class="lsow-icon-quote"></i>

                        <?php echo wp_kses_post($testimonial['text']) ?>

                    </div>

                    <div class="lsow-testimonial-user">

                        <div class="lsow-image-wrapper">
                            <?php echo wp_get_attachment_image($testimonial['image'], 'thumbnail', false, array('class' => 'lsow-image full')); ?>
                        </div>

                        <div class="lsow-text">
                            <h4 class="lsow-author-name"><?php echo esc_html($testimonial['name']) ?></h4>
                            <div class="lsow-author-credentials"><?php echo wp_kses_post($testimonial['credentials']); ?></div>
                        </div>

                    </div>

                </div>

            </div>

        <?php

        endforeach;

        ?>

    </div>

</div>