<?php
/**
 * @var $style
 * @var $align
 * @var $heading
 * @var $subtitle
 * @var $short_text
 */

?>

<div class="lsow-heading lsow-<?php echo $style; ?> lsow-align<?php echo $align; ?>">

    <?php if ($style == 'style2' && !empty($subtitle)): ?>

        <div class="lsow-subtitle"><?php echo esc_html($subtitle); ?></div>

    <?php endif; ?>

    <h3 class="lsow-title"><?php echo wp_kses_post($heading); ?></h3>

    <?php if ($style != 'style3' && !empty($short_text)): ?>

        <p class="lsow-text"><?php echo wp_kses_post($short_text); ?></p>

    <?php endif; ?>

</div>