<?php
/**
 * Template part for displaying Post Types Slider
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package FF_Multipurpose
 */

$portfolio_args = ff_multipurpose_get_section_args( 'portfolio' );

$ff_multipurpose_loop = new WP_Query( $portfolio_args );

if ( $ff_multipurpose_loop->have_posts() ) :
	?>
	<div class="portfolio-main-wrapper">
		<div>
		<?php

		while ( $ff_multipurpose_loop->have_posts() ) :
			$ff_multipurpose_loop->the_post();
			?>
			<div class="portfolio-item ff-grid-3">
				<div class="item-inner-wrapper">
					<?php if ( has_post_thumbnail() ) : ?>
					<div class="portfolio-thumb-wrap">
						<?php the_post_thumbnail( 'ff-multipurpose-portfolio', array( 'class' => 'ff-multipurpose-portfolio' ) ); ?>
						<div class="overlay"></div>
						</a>
					</div>
					<?php endif; ?>

					<div class="portfolio-content">
						<div class="vmiddle-holder">
							<div class="vmiddle">
								<?php the_title( '<h3><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h3>'); ?>
							</div>
						</div>
					</div><!-- .portfolio-content -->
				</div><!-- .item-inner-wrapper -->
			</div><!-- .portfolio-item -->
		<?php
		endwhile;
		?>
		</div><!-- .swiper-wrapper -->
	</div><!-- .portfolio-main-wrapper -->
<?php
endif;

wp_reset_postdata();
