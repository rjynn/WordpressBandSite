<?php
/**
 * Template part for displaying Post Types Slider
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package FF_Multipurpose
 */

$associate_logo_args = ff_multipurpose_get_section_args( 'associate_logo' );

$ff_multipurpose_loop = new WP_Query( $associate_logo_args );

if ( $ff_multipurpose_loop->have_posts() ) :
	?>
	<div class="associate-logo-section associate-logo-col-6">
		<div class="row">
		<?php

		while ( $ff_multipurpose_loop->have_posts() ) :
			$ff_multipurpose_loop->the_post();

			if ( has_post_thumbnail() ) : ?>
			<div class="associate-logo-item ff-grid-2">
				<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'thumbnail' ); ?></a>
			</div><!-- .associate-logo-item -->
		<?php
			endif;
		endwhile;
		?>
		</div><!-- .row -->
	</div><!-- .associate-logo-wrapper -->
<?php
endif;

wp_reset_postdata();
