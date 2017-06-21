<?php
/* If viewing a singular page, return. */
if ( is_404() OR is_singular() )
	return;

get_template_part( 'featured-slider' );

?>

<div class="loop-meta">

	<?php if ( is_home() && !is_front_page() ) { ?>

		<h1 class="loop-title"><?php echo get_post_field( 'post_title', get_queried_object_id() ); ?></h1>

		<div class="loop-description">
			<?php echo apply_filters( 'the_content', get_post_field( 'post_content', get_queried_object_id() ) ); ?>
		</div><!-- .loop-description -->

	<?php } elseif ( is_category() ) { ?>

		<h1 class="loop-title"><?php single_cat_title(); ?></h1>

		<div class="loop-description">
			<?php echo category_description(); ?>
		</div><!-- .loop-description -->

	<?php } elseif ( is_tag() ) { ?>

		<h1 class="loop-title"><?php single_tag_title(); ?></h1>

		<div class="loop-description">
			<?php echo tag_description(); ?>
		</div><!-- .loop-description -->

	<?php } elseif ( is_tax() ) { ?>

		<h1 class="loop-title"><?php single_term_title(); ?></h1>

		<div class="loop-description">
			<?php echo term_description( '', get_query_var( 'taxonomy' ) ); ?>
		</div><!-- .loop-description -->

	<?php } elseif ( is_author() ) { ?>

		<h1 class="loop-title"><?php printf( __( 'Author Archives: %1$s', 'fearless' ), '<span class="fn n">' . get_the_author_meta( 'display_name', get_query_var( 'author' ) ) . '</span>' ); ?></h1>

		<div class="loop-description">
			<?php echo wpautop( get_the_author_meta( 'description', get_query_var( 'author' ) ) ); ?>
		</div><!-- .loop-description -->

	<?php } elseif ( is_search() ) { ?>

		<h1 class="loop-title"><?php printf( esc_attr__( 'Search results for &ldquo;%1$s&rdquo;:', 'fearless' ), '<span>' . get_search_query() . '</span>' ); ?></h1>

	<?php } elseif ( is_post_type_archive() ) { ?>

		<?php $post_type = get_post_type_object( get_query_var( 'post_type' ) ); ?>

		<h1 class="loop-title"><?php post_type_archive_title(); ?></h1>

		<div class="loop-description">
			<?php if ( !empty( $post_type->description ) ) echo wpautop( $post_type->description ); ?>
		</div><!-- .loop-description -->

	<?php } elseif ( is_day() || is_month() || is_year() ) { ?>

		<?php
			if ( is_day() )
				$date = get_the_time( __( 'F d, Y', 'fearless' ) );
			elseif ( is_month() )
				$date = get_the_time( __( 'F Y', 'fearless' ) );
			elseif ( is_year() )
				$date = get_the_time( __( 'Y', 'fearless' ) );
		?>

		<h1 class="loop-title"><?php echo $date; ?></h1>

		<div class="loop-description">
			<?php echo wpautop( sprintf( __( 'Archives for %s.', 'fearless' ), $date ) ); ?>
		</div><!-- .loop-description -->

	<?php } elseif ( is_archive() ) { ?>

		<h1 class="loop-title"><?php _e( 'Archives', 'fearless' ); ?></h1>

	<?php } ?>

</div><!-- .loop-meta -->
