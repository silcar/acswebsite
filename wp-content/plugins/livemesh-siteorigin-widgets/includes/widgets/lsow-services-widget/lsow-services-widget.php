<?php

/*
Widget Name: Livemesh Services
Description: Capture services in a multi-column grid.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/

class LSOW_Services_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lsow-services',
            __('Livemesh Services', 'livemesh-so-widgets'),
            array(
                'description' => __('Create services to display in a column grid.', 'livemesh-so-widgets'),
                'panels_icon' => 'dashicons dashicons-minus',
                'help' => LSOW_PLUGIN_HELP_URL. '#services-widget'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'livemesh-so-widgets'),
                ),

                'style' => array(
                    'type' => 'select',
                    'label' => __('Choose Style', 'livemesh-so-widgets'),
                    'state_emitter' => array(
                        'callback' => 'select',
                        'args' => array('style')
                    ),
                    'default' => 'style1',
                    'options' => array(
                        'style1' => __('Style 1', 'livemesh-so-widgets'),
                        'style2' => __('Style 2', 'livemesh-so-widgets'),
                        'style3' => __('Style 3', 'livemesh-so-widgets'),
                    )
                ),

                'services' => array(
                    'type' => 'repeater',
                    'label' => __('Services', 'livemesh-so-widgets'),
                    'item_name' => __('Service', 'livemesh-so-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='services-title']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(

                        'title' => array(
                            'type' => 'text',
                            'label' => __('Title', 'livemesh-so-widgets'),
                            'description' => __('Title of the service.', 'livemesh-so-widgets'),
                        ),

                        'icon_type' => array(
                            'type' => 'select',
                            'label' => __('Choose Icon Type', 'livemesh-so-widgets'),
                            'default' => 'icon',
                            'state_emitter' => array(
                                'callback' => 'select',
                                'args' => array('icon_type')
                            ),
                            'options' => array(
                                'icon' => __('Icon', 'livemesh-so-widgets'),
                                'icon_image' => __('Icon Image', 'livemesh-so-widgets'),
                            )
                        ),

                        'icon_image' => array(
                            'type' => 'media',
                            'label' => __('Service Image.', 'livemesh-so-widgets'),
                            'state_handler' => array(
                                'icon_type[icon_image]' => array('show'),
                                'icon_type[icon]' => array('hide'),
                            ),
                        ),

                        'icon' => array(
                            'type' => 'icon',
                            'label' => __('Service Icon.', 'livemesh-so-widgets'),
                            'state_handler' => array(
                                'icon_type[icon]' => array('show'),
                                'icon_type[icon_image]' => array('hide'),
                            ),
                        ),

                        'excerpt' => array(
                            'type' => 'textarea',
                            'label' => __('Short description', 'livemesh-so-widgets'),
                            'description' => __('Provide a short description for the service', 'livemesh-so-widgets'),
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

    function enqueue_frontend_scripts($instance) {

        wp_enqueue_style('lsow-frontend-styles', LSOW_PLUGIN_URL . 'assets/css/lsow-frontend.css', array(), LSOW_VERSION);

        wp_enqueue_style('lsow-services', siteorigin_widget_get_plugin_dir_url('lsow-services') . 'css/style.css', array(), LSOW_VERSION);

        parent::enqueue_frontend_scripts($instance);
    }

    function get_template_variables($instance, $args) {
        return array(
            'style' => $instance['style'],
            'services' => !empty($instance['services']) ? $instance['services'] : array(),
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register('lsow-services', __FILE__, 'LSOW_Services_Widget');