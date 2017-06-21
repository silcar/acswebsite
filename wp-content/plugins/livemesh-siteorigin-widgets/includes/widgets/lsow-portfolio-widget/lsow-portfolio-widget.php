<?php

/*
Widget Name: Livemesh Grid
Description: Display posts or custom post types in a multi-column grid.
Author: LiveMesh
Author URI: https://www.livemeshthemes.com
*/

class LSOW_Portfolio_Widget extends SiteOrigin_Widget {

    function __construct() {
        parent::__construct(
            'lsow-portfolio',
            __('Livemesh Grid', 'livemesh-so-widgets'),
            array(
                'description' => __('Showcase your work or posts or any custom post types with a filterable portfolio layout. Make sure that Portfolio Post Type plugin is activated', 'livemesh-so-widgets'),
                'panels_icon' => 'dashicons dashicons-minus',
                'help' => LSOW_PLUGIN_HELP_URL. '#grid-widget'
            ),
            array(),
            false,
            plugin_dir_path(__FILE__)
        );
    }

    function initialize() {

        $this->register_frontend_scripts(
            array(
                array(
                    'lsow-isotope',
                    LSOW_PLUGIN_URL . 'assets/js/isotope.pkgd' . LSOW_JS_SUFFIX . '.js',
                    array('jquery'),
                    LSOW_VERSION
                ),
                array(
                    'lsow-imagesloaded',
                    LSOW_PLUGIN_URL . 'assets/js/imagesloaded.pkgd' . LSOW_JS_SUFFIX . '.js',
                    array('jquery'),
                    LSOW_VERSION
                ),
            )
        );

        $this->register_frontend_styles(
            array(

                array(
                    'lsow-frontend-styles',
                    LSOW_PLUGIN_URL . 'assets/css/lsow-frontend.css',
                    array(),
                    LSOW_VERSION
                ),

                array(
                    'lsow-icomoon-styles',
                    LSOW_PLUGIN_URL . 'assets/css/icomoon.css',
                    array(),
                    LSOW_VERSION
                ),
            )
        );

        $this->register_frontend_scripts(array(
                array(
                    'lsow-portfolio',
                    plugin_dir_url(__FILE__) . 'js/portfolio' . LSOW_JS_SUFFIX . '.js',
                    array('jquery')
                )
            )
        );

        $this->register_frontend_styles(array(
                array(
                    'lsow-portfolio',
                    plugin_dir_url(__FILE__) . 'css/style.css'
                )
            )
        );
    }

    function get_widget_form() {
        return
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Title', 'livemesh-so-widgets'),
                ),

                'heading' => array(
                    'type' => 'text',
                    'label' => __('Heading for the grid', 'livemesh-so-widgets'),
                ),

                'posts' => array(
                    'type' => 'posts',
                    'label' => __('Posts query', 'livemesh-so-widgets'),
                    'description' => __('After you build the query, make sure you choose the right taxonomy below to display for your posts and filter on, based on the post type selected during build query.', 'livemesh-so-widgets'),
                ),

                'taxonomy_filter' => array(
                    'type' => 'select',
                    'label' => __('Choose the taxonomy to display and filter on.', 'livemesh-so-widgets'),
                    'description' => __('Choose the taxonomy information to display for posts/portfolio and the taxonomy that is used to filter the portfolio/post. Takes effect only if no taxonomy filters are specified when building query.', 'livemesh-so-widgets'),
                    'options' => lsow_get_taxonomies_map(),
                    'default' => 'portfolio_category',
                ),

                'settings' => array(
                    'type' => 'section',
                    'label' => __('Settings', 'livemesh-so-widgets'),
                    'fields' => array(

                        'filterable' => array(
                            'type' => 'checkbox',
                            'label' => __('Filterable?', 'livemesh-so-widgets'),
                            'default' => true
                        ),

                        'layout_mode' => array(
                            'type' => 'select',
                            'label' => __('Choose a layout for the grid', 'livemesh-so-widgets'),
                            'state_emitter' => array(
                                'callback' => 'select',
                                'args' => array('layout_mode')
                            ),
                            'default' => 'fitRows',
                            'options' => array(
                                'fitRows' => __('Fit Rows', 'livemesh-so-widgets'),
                                'masonry' => __('Masonry', 'livemesh-so-widgets'),
                            )
                        ),

                        'image_linkable' => array(
                            'type' => 'checkbox',
                            'label' => __('Link the image to the post/portfolio?', 'livemesh-so-widgets'),
                            'default' => true
                        ),

                        'display_title' => array(
                            'type' => 'checkbox',
                            'label' => __('Display project title below the post/portfolio?', 'livemesh-so-widgets'),
                            'default' => true
                        ),

                        'display_summary' => array(
                            'type' => 'checkbox',
                            'label' => __('Display project excerpt/summary below the post/portfolio?', 'livemesh-so-widgets'),
                            'default' => true
                        ),

                        'post_meta' => array(
                            'type' => 'section',
                            'label' => __('Post Meta', 'livemesh-so-widgets'),
                            'fields' => array(

                                'display_author' => array(
                                    'type' => 'checkbox',
                                    'label' => __('Display post author info below the post item?', 'livemesh-so-widgets'),
                                    'default' => false
                                ),

                                'display_post_date' => array(
                                    'type' => 'checkbox',
                                    'label' => __('Display post date info below the post item?', 'livemesh-so-widgets'),
                                    'default' => false
                                ),

                                'display_taxonomy' => array(
                                    'type' => 'checkbox',
                                    'label' => __('Display taxonomy info below the post item?', 'livemesh-so-widgets'),
                                    'default' => false
                                ),

                            )

                        ),

                        'per_line' => array(
                            'type' => 'slider',
                            'label' => __('Columns per row', 'livemesh-so-widgets'),
                            'min' => 1,
                            'max' => 5,
                            'integer' => true,
                            'default' => 4
                        ),

                        'gutter' => array(
                            'type' => 'number',
                            'label' => __('Gutter', 'livemesh-so-widgets'),
                            'description' => __('Space between columns in masonry grid.', 'livemesh-so-widgets'),
                            'default' => 20
                        ),

                        'responsive' => array(
                            'type' => 'section',
                            'label' => __('Responsive', 'livemesh-so-widgets'),
                            'hide' => true,
                            'fields' => array(
                                'tablet' => array(
                                    'type' => 'section',
                                    'label' => __('Tablet', 'livemesh-so-widgets'),
                                    'fields' => array(

                                        'gutter' => array(
                                            'type' => 'number',
                                            'label' => __('Gutter', 'livemesh-so-widgets'),
                                            'description' => __('Space between columns.', 'livemesh-so-widgets'),
                                            'default' => 10
                                        ),

                                        'width' => array(
                                            'type' => 'text',
                                            'label' => __('Resolution', 'livemesh-so-widgets'),
                                            'description' => __('The resolution to treat as a tablet resolution.', 'livemesh-so-widgets'),
                                            'default' => 800,
                                            'sanitize' => 'intval',
                                        )
                                    )
                                ),
                                'mobile' => array(
                                    'type' => 'section',
                                    'label' => __('Mobile Phone', 'livemesh-so-widgets'),
                                    'fields' => array(

                                        'gutter' => array(
                                            'type' => 'number',
                                            'label' => __('Gutter', 'livemesh-so-widgets'),
                                            'description' => __('Space between columns.', 'livemesh-so-widgets'),
                                            'default' => 10
                                        ),

                                        'width' => array(
                                            'type' => 'text',
                                            'label' => __('Resolution', 'livemesh-so-widgets'),
                                            'description' => __('The resolution to treat as a mobile resolution.', 'livemesh-so-widgets'),
                                            'default' => 480,
                                            'sanitize' => 'intval',
                                        )
                                    )
                                )

                            )
                        ),
                    )
                ),
            );

    }

    function modify_form($form) {
        $form['taxonomy_filter']['options'] = lsow_get_taxonomies_map();
        return $form;
    }

    function get_less_variables($instance) {
        return array(

            'gutter' => intval($instance['settings']['gutter']) . 'px',

            // All the responsive sizes
            'tablet_width' => intval($instance['settings']['responsive']['tablet']['width']) . 'px',
            'tablet_gutter' => intval($instance['settings']['responsive']['tablet']['gutter']) . 'px',
            'mobile_width' => intval($instance['settings']['responsive']['mobile']['width']) . 'px',
            'mobile_gutter' => intval($instance['settings']['responsive']['mobile']['gutter']) . 'px',
        );
    }

    function get_template_variables($instance, $args) {
        return array(
            'posts' => $instance['posts'],
            'taxonomy_filter' => $instance['taxonomy_filter'],
            'heading' => $instance['heading'],
            'settings' => $instance['settings']
        );
    }

}

siteorigin_widget_register('lsow-portfolio', __FILE__, 'LSOW_Portfolio_Widget');