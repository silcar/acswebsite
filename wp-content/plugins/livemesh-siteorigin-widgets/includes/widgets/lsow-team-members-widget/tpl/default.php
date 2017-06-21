<?php
/**
 * @var $style
 * @var $settings
 * @var $team_members
 */

?>

<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>


<?php $column_style = ''; ?>

<?php if ($style == 'style1'): ?>

    <?php $column_style = lsow_get_column_class(intval($settings['per_line'])); ?>

<?php endif; ?>

<div class="lsow-team-members lsow-<?php echo $style; ?> lsow-container">

    <?php foreach ($team_members as $team_member): ?>

        <div class="lsow-team-member-wrapper <?php echo $column_style; ?>">

            <div class="lsow-team-member">

                <div class="lsow-image-wrapper">

                    <?php echo wp_get_attachment_image($team_member['image'], 'full', false, array('class' => 'lsow-image full')); ?>

                    <?php if ($style == 'style1'): ?>

                        <?php include 'social-profile.php'; ?>

                    <?php endif; ?>

                </div>

                <div class="lsow-team-member-text">

                    <h3 class="lsow-title"><?php echo esc_html($team_member['name']) ?></h3>

                    <div class="lsow-team-member-position">

                        <?php echo do_shortcode($team_member['position']) ?>

                    </div>

                    <div class="lsow-team-member-details">

                        <?php echo do_shortcode($team_member['details']) ?>

                    </div>

                    <?php if ($style == 'style2'): ?>

                        <?php include 'social-profile.php'; ?>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    <?php

    endforeach;

    ?>

</div>