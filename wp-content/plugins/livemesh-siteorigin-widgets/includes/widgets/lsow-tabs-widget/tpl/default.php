<?php
/**
 * @var $tabs
 * @var $style
 * @var $mobile_width
 * @var $icon_type
 */

if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'];

$plain_styles = array('style2', 'style6', 'style7');

if (in_array($style, $plain_styles, true)):

    $icon_type = 'none'; // do not display icons for plain styles even if chosen by the user

endif;

$vertical_class = '';

$vertical_styles = array('style7', 'style8', 'style9', 'style10');

if (in_array($style, $vertical_styles, true)):

    $vertical_class = 'lsow-vertical';

endif;

foreach ($tabs as $tab) :

    $tab_id = sanitize_title_with_dashes($tab['title']) . '-' . uniqid();

    $tab_title = '<a href="#' . $tab_id . '">';

    if ($icon_type == 'icon_image') :

        $tab_title .= '<span class="lsow-image-wrapper">';

        $tab_title .= wp_get_attachment_image($tab['icon_image'], 'thumbnail', false, array('class' => 'lsow-image'));

        $tab_title .= '</span>';

    elseif ($icon_type == 'icon') :

        $tab_title .= '<span class="lsow-icon-wrapper">';

        $tab_title .= siteorigin_widget_get_icon($tab['icon']);

        $tab_title .= '</span>';

    endif;

    $tab_title .= '<span class="lsow-tab-title">';

    $tab_title .= esc_html($tab['title']);

    $tab_title .= '</span>';

    $tab_title .= '</a>';

    $tab_nav = '<div class="lsow-tab">' . $tab_title . '</div>';
    $tab_content = '<div id="' . $tab_id . '" class="lsow-tab-pane">' . do_shortcode($tab['tab_content']) . '</div>';

    $tab_elements[] = $tab_nav;
    $tab_panes[] = $tab_content;

endforeach;

?>

<div class="lsow-tabs <?php echo $vertical_class; ?> <?php echo esc_attr($style); ?>"
     data-mobile-width="<?php echo intval($mobile_width); ?>">

    <a href="#" class="lsow-tab-mobile-menu"><i class="lsow-icon-menu"></i>&nbsp;</a>

    <div class="lsow-tab-nav">

        <?php

        foreach ($tab_elements as $tab_nav) :

            echo $tab_nav;

        endforeach;

        ?>

    </div>

    <div class="lsow-tab-panes">

        <?php

        foreach ($tab_panes as $tab_pane) :

            echo $tab_pane;

        endforeach;

        ?>

    </div>

</div>