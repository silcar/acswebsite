<?php
/**
 * @var $clients
 * @var $settings
 */

?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<?php $num_of_columns = intval($settings['per_line']); ?>

<?php $column_style = lsow_get_column_class($num_of_columns); ?>

<div class="lsow-clients lsow-container">

    <?php $column_count = 0; ?>

    <?php foreach ($clients as $client): ?>

        <div class="lsow-client <?php echo $column_style; ?> lsow-zero-margin">

            <?php echo wp_get_attachment_image($client['image'], 'full', false, array('class' => 'lsow-image full', 'alt' => $client['name'])); ?>

            <div class="lsow-client-name">

                <?php if (!empty($client['link'])): ?>

                    <a href="<?php echo sow_esc_url($client['link']); ?>" title="<?php echo esc_html($client['name']); ?>" target="_blank"><?php echo esc_html($client['name']); ?></a>

                <?php else: ?>

                    <?php echo esc_html($client['name']); ?>

                <?php endif; ?>

            </div>

            <div class="lsow-image-overlay"></div>

        </div>

    <?php

    endforeach;

    ?>

</div>