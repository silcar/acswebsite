<?php

/*
Widget Name: Livemesh Button
Description: Flat style buttons with rich set of customization options.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/


class LSOW_Button_Widget extends SiteOrigin_Widget {

    /**
     * Holds the ID for the button element used for generating custom CSS.
     */
    private $element_id = '';

    function __construct() {
        parent::__construct(
            "lsow-button",
            __("Livemesh Button", "livemesh-so-widgets"),
            array(
                "description" => __("Flat style buttons with rich set of customization options.", "livemesh-so-widgets"),
                "panels_icon" => "dashicons dashicons-minus",
                'help' => LSOW_PLUGIN_HELP_URL. '#button-widget'

            ),
            array(),
            array(
                "widget_title" => array(
                    "type" => "text",
                    "label" => __("Title", "livemesh-so-widgets"),
                ),

                "href" => array(
                    "type" => "link",
                    "description" => __("The URL to which button should point to.", "livemesh-so-widgets"),
                    "label" => __("Target URL", "livemesh-so-widgets"),
                    "default" => __("http://targeturl.com", "livemesh-so-widgets"),
                ),
                "text" => array(
                    "type" => "text",
                    "description" => __("The button title or text. ", "livemesh-so-widgets"),
                    "label" => __("Button Text", "livemesh-so-widgets"),
                    "default" => __("Buy Now", "livemesh-so-widgets"),
                ),

                'icon_type' => array(
                    'type' => 'select',
                    'label' => __('Choose Icon Type', 'livemesh-so-widgets'),
                    'default' => 'none',
                    'state_emitter' => array(
                        'callback' => 'select',
                        'args' => array('icon_type')
                    ),
                    'options' => array(
                        'none' => __('None', 'livemesh-so-widgets'),
                        'icon' => __('Icon', 'livemesh-so-widgets'),
                        'icon_image' => __('Icon Image', 'livemesh-so-widgets'),
                    )
                ),

                'icon_image' => array(
                    'type' => 'media',
                    'label' => __('Service Image.', 'livemesh-so-widgets'),
                    'state_handler' => array(
                        'icon_type[icon_image]' => array('show'),
                        '_else[icon_type]' => array('hide'),
                    ),
                ),

                'icon' => array(
                    'type' => 'icon',
                    'label' => __('Service Icon.', 'livemesh-so-widgets'),
                    'state_handler' => array(
                        'icon_type[icon]' => array('show'),
                        '_else[icon_type]' => array('hide'),
                    ),
                ),


                'settings' => array(
                    'type' => 'section',
                    'label' => __('Settings', 'livemesh-so-widgets'),
                    'fields' => array(

                        "class" => array(
                            "type" => "text",
                            "description" => __("The CSS class name for the button element.", "livemesh-so-widgets"),
                            "label" => __("Class", "livemesh-so-widgets"),
                            "default" => "",
                            "optional" => "true"
                        ),
                        "style" => array(
                            "type" => "text",
                            "description" => __("Inline CSS styling for the button element.", "livemesh-so-widgets"),
                            "label" => __("Style", "livemesh-so-widgets"),
                            "optional" => "true"
                        ),
                        "color" => array(
                            "type" => "select",
                            "description" => __("The color of the button.", "livemesh-so-widgets"),
                            "label" => __("Color", "livemesh-so-widgets"),
                            "options" => array(
                                "default" => __("Default", "livemesh-so-widgets"),
                                "custom" => __("Custom", "livemesh-so-widgets"),
                                "black" => __("Black", "livemesh-so-widgets"),
                                "blue" => __("Blue", "livemesh-so-widgets"),
                                "cyan" => __("Cyan", "livemesh-so-widgets"),
                                "green" => __("Green", "livemesh-so-widgets"),
                                "orange" => __("Orange", "livemesh-so-widgets"),
                                "pink" => __("Pink", "livemesh-so-widgets"),
                                "red" => __("Red", "livemesh-so-widgets"),
                                "teal" => __("Teal", "livemesh-so-widgets"),
                                "trans" => __("Transparent", "livemesh-so-widgets"),
                                "semitrans" => __("Semi Transparent", "livemesh-so-widgets"),
                            ),
                            'state_emitter' => array(
                                'callback' => 'select',
                                'args' => array('color')
                            ),
                        ),
                        "custom_color" => array(
                            "type" => "color",
                            "description" => __("Custom color of the button.", "livemesh-so-widgets"),
                            "label" => __("Custom button color", "livemesh-so-widgets"),
                            'state_handler' => array(
                                'color[custom]' => array('show'),
                                '_else[color]' => array('hide'),
                            ),
                        ),
                        "hover_color" => array(
                            "type" => "color",
                            "description" => __("Hover color of the button.", "livemesh-so-widgets"),
                            "label" => __("Custom button hover color", "livemesh-so-widgets"),
                            "optional" => "true"
                        ),
                        "type" => array(
                            "type" => "select",
                            "label" => __("Button Size", "livemesh-so-widgets"),
                            "options" => array(
                                "medium" => __("Medium", "livemesh-so-widgets"),
                                "large" => __("Large", "livemesh-so-widgets"),
                                "small" => __("Small", "livemesh-so-widgets"),
                            )
                        ),

                        'rounded' => array(
                            'type' => 'checkbox',
                            'label' => __('Display rounded button?', 'livemesh-so-widgets'),
                            'default' => false
                        ),
                        "target" => array(
                            "type" => "checkbox",
                            "label" => __("Open the link in new window", "livemesh-so-widgets"),
                            "default" => true,
                        ),
                        "align" => array(
                            "type" => "select",
                            "description" => __("Alignment of the button displayed.", "livemesh-so-widgets"),
                            "label" => __("Align", "livemesh-so-widgets"),
                            "options" => array(
                                "none" => __("None", "livemesh-so-widgets"),
                                "center" => __("Center", "livemesh-so-widgets"),
                                "left" => __("Left", "livemesh-so-widgets"),
                                "right" => __("Right", "livemesh-so-widgets"),
                            ),
                            'default' => 'none'
                        ),
                    )
                ),
            )
        );
    }

    function enqueue_frontend_scripts($instance) {

        wp_enqueue_style('lsow-button', siteorigin_widget_get_plugin_dir_url('lsow-button') . 'css/style.css', array(), LSOW_VERSION);

        $custom_css = $this->custom_css($instance);
        if (!empty($custom_css))
            wp_add_inline_style('lsow-button', $custom_css);

        parent::enqueue_frontend_scripts($instance);
    }

    /**
     * Generate the custom layout CSS required
     */
    protected function custom_css($instance) {

        $custom_css = '';

        $this->element_id = uniqid('lsow-button-');

        $id_selector = '#' . $this->element_id;

        $button_color = $instance['settings']["color"];

        $custom_color = $instance['settings']["custom_color"];

        $hover_color = $instance['settings']["hover_color"];

        if ($button_color == "custom") {
            if (!empty($custom_color)) {

                $custom_css .= $id_selector . '.lsow-button { background-color:' . $custom_color . '; }' . "\n";

                // Automatically set a hover color for custom color if none specified by user
                if (empty($hover_color)) {
                    $hover_color = lsow_color_luminance($custom_color, 0.05);
                }
            }
        }

        // Apply the hover color for button of any color provided one is specified
        if (!empty($hover_color)) {
            $custom_css .= $id_selector . '.lsow-button:hover { background-color:' . $hover_color . '; }';
        }

        return $custom_css;
    }

    function get_template_variables($instance, $args) {
        return array(
            "id" => $this->element_id,
            "style" => $instance['settings']["style"],
            "class" => $instance['settings']["class"],
            "color" => $instance['settings']["color"],
            "custom_color" => $instance['settings']["custom_color"],
            "hover_color" => $instance['settings']["hover_color"],
            "type" => $instance['settings']["type"],
            "align" => $instance['settings']["align"],
            "target" => $instance['settings']["target"],
            "rounded" => $instance['settings']["rounded"],
            "href" => (!empty($instance['href'])) ? sow_esc_url($instance['href']) : '',
            "text" => $instance["text"],
            'icon_type' => $instance['icon_type'],
            'icon_image' => $instance['icon_image'],
            'icon' => $instance['icon'],
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register("lsow-button", __FILE__, "LSOW_Button_Widget");