<?php
/**
 * @var $carousel_settings
 * @var $settings
 * @var $posts
 */

if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'];

$query_args = siteorigin_widget_post_selector_process_query($posts);

// Use the processed post selector query to find posts.
$loop = new WP_Query($query_args);

// Loop through the posts and do something with them.
if ($loop->have_posts()) : ?>

    <div class="lsow-posts-carousel lsow-container" <?php foreach ($carousel_settings as $key => $val) : ?>
        <?php if (!empty($val)) : ?>
            data-<?php echo $key . '="' . esc_attr($val) . '"' ?>
        <?php endif ?>
    <?php endforeach; ?>>

        <?php $taxonomy = $settings['taxonomy_chosen']; ?>

        <?php while ($loop->have_posts()) : $loop->the_post(); ?>

            <div data-id="id-<?php the_ID(); ?>" class="lsow-posts-carousel-item">

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

            </div><!--.lsow-posts-carousel-item -->

        <?php endwhile; ?>

        <?php wp_reset_postdata(); ?>

    </div> <!-- .lsow-posts-carousel -->

<?php endif; ?>