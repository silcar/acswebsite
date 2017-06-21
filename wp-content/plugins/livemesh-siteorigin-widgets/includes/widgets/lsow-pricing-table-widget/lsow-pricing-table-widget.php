<?php

/*
Widget Name: Livemesh Pricing Table
Description: Display pricing plans in a multi-column grid.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/

class LSOW_Pricing_Table_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lsow-pricing-plans',
            __('Livemesh Pricing Table', 'livemesh-so-widgets'),
            array(
                'description' => __('Display pricing table in a multi-column grid.', 'livemesh-so-widgets'),
                'panels_icon' => 'dashicons dashicons-minus',
                'help' => LSOW_PLUGIN_HELP_URL. '#pricing-table'
            ),
            array(),
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'livemesh-so-widgets'),
                ),

                'pricing-plans' => array(
                    'type' => 'repeater',
                    'label' => __('Pricing Table', 'livemesh-so-widgets'),
                    'item_name' => __('Pricing Plan', 'livemesh-so-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='pricing-plans-title']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'pricing_title' => array(
                            'type' => 'text',
                            'label' => __('Pricing Plan Title', 'livemesh-so-widgets'),
                            'description' => __('The title for the pricing plan', 'livemesh-so-widgets'),
                        ),

                        'tagline' => array(
                            'type' => 'text',
                            'label' => __('Tagline Text', 'livemesh-so-widgets'),
                            'description' => __('Provide any subtitle or taglines like "Most Popular", "Best Value", "Best Selling", "Most Flexible" etc. that you would like to use for this pricing plan.', 'livemesh-so-widgets'),
                        ),

                        'image' => array(
                            'type' => 'media',
                            'label' => __('Image', 'livemesh-so-widgets'),
                        ),

                        'price_tag' => array(
                            'type' => 'text',
                            'label' => __('Price Tag', 'livemesh-so-widgets'),
                            'description' => __('Enter the price tag for the pricing plan. HTML is accepted.', 'livemesh-so-widgets'),
                        ),

                        'button_text' => array(
                            'type' => 'text',
                            'label' => __('Text for Pricing Link/Button', 'livemesh-so-widgets'),
                            'description' => __('Provide the text for the link or the button shown for this pricing plan.', 'livemesh-so-widgets'),
                        ),

                        'url' => array(
                            'type' => 'link',
                            'label' => __('URL for the Pricing link/button', 'livemesh-so-widgets'),
                            'description' => __('Provide the target URL for the link or the button shown for this pricing plan.', 'livemesh-so-widgets'),
                        ),

                        'button_new_window' => array(
                            'type' => 'checkbox',
                            'label' => __('Open Button URL in a new window', 'livemesh-so-widgets'),
                        ),

                        'highlight' => array(
                            'type' => 'checkbox',
                            'label' => __('Highlight Pricing Plan', 'livemesh-so-widgets'),
                            'description' => __('Specify if you want to highlight the pricing plan.', 'livemesh-so-widgets'),
                        ),

                        'items' => array(
                            'type' => 'repeater',
                            'label' => __('Pricing Plan Details', 'livemesh-so-widgets'),
                            'item_name' => __('Pricing Item', 'livemesh-so-widgets'),
                            'item_label' => array(
                                'selector' => "[id*='pricing-plans-items-text']",
                                'update_event' => 'change',
                                'value_method' => 'val'
                            ),
                            'fields' => array(
                                'title' => array(
                                    'type' => 'text',
                                    'label' => __('Title', 'livemesh-so-widgets'),
                                ),
                                'value' => array(
                                    'type' => 'text',
                                    'label' => __('Value', 'livemesh-so-widgets'),
                                ),
                                'icon_new' => array(
                                    'type' => 'icon',
                                    'label' => __('Icon', 'livemesh-so-widgets'),
                                ),
                            ),
                        ),


                    )
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('Settings', 'livemesh-so-widgets'),
                    'fields' => array(

                        'per_line' => array(
                            'type' => 'slider',
                            'label' => __('Pricing Columns per row', 'livemesh-so-widgets'),
                            'min' => 1,
                            'max' => 5,
                            'integer' => true,
                            'default' => 4
                        ),
                    )
                ),

            )
        );
    }

    function initialize() {

        $this->register_frontend_styles(array(
            array(
                'lsow-pricing-plans',
                plugin_dir_url(__FILE__) . 'css/style.css'
            )
        ));
    }

    function get_template_variables($instance, $args) {
        return array(
            'pricing_plans' => !empty($instance['pricing-plans']) ? $instance['pricing-plans'] : array(),
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register('lsow-pricing-plans', __FILE__, 'LSOW_Pricing_Table_Widget');