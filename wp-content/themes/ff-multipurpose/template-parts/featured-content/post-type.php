<?php
/**
 * Template part for displaying Post Types Slider
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package FF_Multipurpose
 */

$ff_multipurpose_args = ff_multipurpose_get_section_args( 'featured_content' );

$ff_multipurpose_loop = new WP_Query( $ff_multipurpose_args );

if ( $ff_multipurpose_loop->have_posts() ) :
	?>
	<div class="featured-content-block-list">
		<div class="row">
			<?php
			while ( $ff_multipurpose_loop->have_posts() ) :
				$ff_multipurpose_loop->the_post();
				?>
				<div class="latest-posts-item ff-grid-4">
					<div class="latest-posts-wrapper inner-block-shadow">
						<?php
						$ff_multipurpose_cats = ff_multipurpose_get_featured_content_cats();

						if ( has_post_thumbnail() || $ff_multipurpose_cats ) : ?>
						<div class="latest-posts-thumb">
							<?php if ( has_post_thumbnail() ) : ?>
							<a class="image-hover-zoom" href="<?php the_permalink(); ?>" >
								<?php the_post_thumbnail(); ?>
							</a>
							<?php endif; ?>

								<?php
								if ( $ff_multipurpose_cats ) {
									echo $ff_multipurpose_cats;
								}
								?>
						</div><!-- latest-posts-thumb  -->
						<?php endif; ?>

						<div class="latest-posts-text-content-wrapper">
							<div class="latest-posts-text-content">
								<?php the_title( '<h3 class="latest-posts-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h3>'); ?>
								<span class="title-divider clear-fix"></span>

								<?php ff_multipurpose_featured_content_meta();  ?>

								<?php the_excerpt(); ?>
							</div><!-- .latest-posts-text-content -->
						</div><!-- .latest-posts-text-content-wrapper -->
					</div><!-- .latest-posts-wrapper -->
				</div><!-- .latest-posts-item -->
			<?php endwhile; ?>
		</div><!-- .row -->
	</div><!-- .featured-content-block-list -->	
<?php
endif;

wp_reset_postdata();
