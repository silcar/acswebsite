<?php
/**
 * @var $settings
 * @var $heading
 * @var $taxonomy_filter
 * @var $posts
 */

if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'];

$current_page = get_queried_object_id();

$query_args = siteorigin_widget_post_selector_process_query($posts);

// Use the processed post selector query to find posts.
$loop = new WP_Query($query_args);

// Loop through the posts and do something with them.
if ($loop->have_posts()) : ?>

    <div class="lsow-portfolio-wrap lsow-container">

        <?php $column_style = lsow_get_column_class(intval($settings['per_line'])); ?>

        <?php
        // Check if any taxonomy filter has been applied
        list($chosen_terms, $taxonomy) = lsow_get_chosen_terms($posts);
        if (empty($chosen_terms))
            $taxonomy = $taxonomy_filter;

        ?>

        <div class="lsow-portfolio-header">

            <?php if (!empty($heading)) ?>

            <h3 class="lsow-heading"><?php echo wp_kses_post($heading); ?></h3>

            <?php

            if ($settings['filterable'])
                echo lsow_get_taxonomy_terms_filter($taxonomy, $chosen_terms);

            ?>

        </div>

        <div class="lsow-portfolio js-isotope lsow-<?php echo $settings['layout_mode']; ?>"
             data-isotope='{ "itemSelector": ".lsow-portfolio-item", "layoutMode": "<?php echo esc_attr($settings['layout_mode']); ?>" }'>

            <?php while ($loop->have_posts()) : $loop->the_post(); ?>

                <?php
                if (get_the_ID() === $current_page)
                    continue; // skip the current page since they can run into infinite loop when users choose All option in build query
                ?>

                <?php
                $style = '';
                $terms = get_the_terms(get_the_ID(), $taxonomy);
                if (!empty($terms) && !is_wp_error($terms)) {
                    foreach ($terms as $term) {
                        $style .= ' term-' . $term->term_id;
                    }
                }
                ?>

                <div data-id="id-<?php the_ID(); ?>"
                     class="lsow-portfolio-item <?php echo $style; ?> <?php echo $column_style; ?> lsow-zero-margin">

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <?php if ($thumbnail_exists = has_post_thumbnail()): ?>

                            <div class="lsow-project-image">

                                <?php if ($settings['image_linkable']): ?>

                                    <a href="<?php the_permalink(); ?>"> <?php the_post_thumbnail('large'); ?> </a>

                                <?php else: ?>

                                    <?php the_post_thumbnail('large'); ?>

                                <?php endif; ?>

                                <div class="lsow-image-info">

                                    <div class="lsow-entry-info">

                                        <?php the_title('<h3 class="lsow-post-title"><a href="' . get_permalink() . '" title="' . get_the_title() . '"
                                               rel="bookmark">', '</a></h3>'); ?>

                                        <?php echo lsow_get_taxonomy_info($taxonomy); ?>

                                    </div>

                                </div>

                                <div class="lsow-image-overlay"></div>

                            </div>

                        <?php endif; ?>

                        <?php if ($settings['display_title'] || $settings['display_summary']) : ?>

                            <div class="lsow-entry-text-wrap <?php echo($thumbnail_exists ? '' : ' nothumbnail'); ?>">

                                <?php if ($settings['display_title']) : ?>

                                    <?php the_title('<h3 class="entry-title"><a href="' . get_permalink() . '" title="' . get_the_title() . '"
                                               rel="bookmark">', '</a></h3>'); ?>

                                <?php endif; ?>

                                <?php if ($settings['post_meta']['display_post_date'] || $settings['post_meta']['display_author'] || $settings['post_meta']['display_taxonomy']) : ?>

                                    <div class="lsow-entry-meta">

                                        <?php if ($settings['post_meta']['display_author']): ?>

                                            <?php echo lsow_entry_author(); ?>

                                        <?php endif; ?>

                                        <?php if ($settings['post_meta']['display_post_date']): ?>

                                            <?php echo lsow_entry_published(); ?>

                                        <?php endif; ?>

                                        <?php if ($settings['post_meta']['display_taxonomy']): ?>

                                            <?php echo lsow_get_taxonomy_info($taxonomy); ?>

                                        <?php endif; ?>

                                    </div>

                                <?php endif; ?>

                                <?php if ($settings['display_summary']) : ?>

                                    <div class="entry-summary">

                                        <?php echo get_the_excerpt(); ?>

                                    </div>

                                <?php endif; ?>

                            </div>

                        <?php endif; ?>

                    </article>
                    <!-- .hentry -->

                </div><!--Isotope element -->

            <?php endwhile; ?>

            <?php wp_reset_postdata(); ?>

        </div>
        <!-- Isotope items -->

    </div>

<?php endif; ?>