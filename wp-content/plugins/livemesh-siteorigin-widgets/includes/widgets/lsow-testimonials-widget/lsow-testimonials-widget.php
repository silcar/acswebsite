<?php

/*
Widget Name: Livemesh Testimonials
Description: Display testimonials from your clients/customers in a multi-column grid.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/

class LSOW_Testimonials_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lsow-testimonials',
            __('Livemesh Testimonials', 'livemesh-so-widgets'),
            array(
                'description' => __('Display testimonials in a responsive multi-column grid.', 'livemesh-so-widgets'),
                'panels_icon' => 'dashicons dashicons-minus',
                'help' => LSOW_PLUGIN_HELP_URL. '#testimonials-widgets'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'livemesh-so-widgets'),
                ),
                'testimonials' => array(
                    'type' => 'repeater',
                    'label' => __('Testimonials', 'livemesh-so-widgets'),
                    'item_name' => __('Testimonial', 'livemesh-so-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='testimonials-name']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'name' => array(
                            'type' => 'text',
                            'label' => __('Name', 'livemesh-so-widgets'),
                            'description' => __('The author of the testimonial', 'livemesh-so-widgets'),
                        ),

                        'credentials' => array(
                            'type' => 'text',
                            'label' => __('Author Details', 'livemesh-so-widgets'),
                            'description' => __('The details of the author like company name, position held, company URL etc. HTML accepted.', 'livemesh-so-widgets'),
                        ),

                        'image' => array(
                            'type' => 'media',
                            'label' => __('Image', 'livemesh-so-widgets'),
                        ),

                        'text' => array(
                            'type' => 'tinymce',
                            'label' => __('Text', 'livemesh-so-widgets'),
                            'description' => __('What your customer had to say', 'livemesh-so-widgets'),
                        ),
                    )
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('Settings', 'livemesh-so-widgets'),
                    'fields' => array(

                        'per_line' => array(
                            'type' => 'slider',
                            'label' => __('Columns per row', 'livemesh-so-widgets'),
                            'min' => 1,
                            'max' => 5,
                            'integer' => true,
                            'default' => 3
                        ),
                    )
                ),
            )
        );
    }

    function initialize() {

        $this->register_frontend_styles(array(
            array(
                'lsow-testimonials',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));
    }

    function get_template_variables($instance, $args) {
        return array(
            'testimonials' => !empty($instance['testimonials']) ? $instance['testimonials'] : array(),
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register('lsow-testimonials', __FILE__, 'LSOW_Testimonials_Widget');