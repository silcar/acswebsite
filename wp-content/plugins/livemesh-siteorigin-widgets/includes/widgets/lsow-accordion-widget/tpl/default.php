<?php
/**
 * @var $accordion
 * @var $toggle
 * @var $style
 */
?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<div class="lsow-accordion <?php echo $style; ?>" data-toggle="<?php echo ($toggle ? "true" : "false"); ?>">

    <?php foreach ($accordion as $panel) : ?>

        <div class="lsow-panel">

            <div class="lsow-panel-title"><?php echo esc_html($panel['title']); ?></div>

            <div class="lsow-panel-content"><?php echo do_shortcode($panel['panel_content']); ?></div>

        </div>

        <?php

    endforeach;

    ?>

</div>