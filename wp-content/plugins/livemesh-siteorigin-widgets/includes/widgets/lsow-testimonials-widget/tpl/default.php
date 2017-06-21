<?php
/**
 * @var $settings
 * @var $testimonials
 */
?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<?php $column_style = lsow_get_column_class(intval($settings['per_line'])); ?>

<div class="lsow-testimonials lsow-container">

    <?php foreach ($testimonials as $testimonial) : ?>

        <div class="lsow-testimonial <?php echo $column_style; ?>">

            <div class="lsow-testimonial-text">
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

    <?php

    endforeach;

    ?>

</div>