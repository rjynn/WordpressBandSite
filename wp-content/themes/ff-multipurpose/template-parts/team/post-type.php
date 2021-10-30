<?php
/**
 * Template part for displaying Post Types Slider
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package FF_Multipurpose
 */

$team_args = ff_multipurpose_get_section_args( 'team' );

$ff_multipurpose_loop = new WP_Query( $team_args );

if ( $ff_multipurpose_loop->have_posts() ) :
	?>
	<div class="teams-section">
		<div class="inner-wrapper">
		<?php

		while ( $ff_multipurpose_loop->have_posts() ) :
			$ff_multipurpose_loop->the_post();
			?>
			<!-- .team-item  -->
			<div class="ff-grid-3">
				<div class="thumb-summary-wrap inner-block-shadow">
					<?php if ( has_post_thumbnail() ) : ?>
					<div class="team-thumb">
						<a class="image-hover-zoom" href="<?php the_permalink(); ?>" >
							<?php the_post_thumbnail( 'ff-multipurpose-portfolio' ); ?>
						</a>
					</div><!-- .team-thumb-->
					<?php endif; ?>

					<div class="team-text-wrap">
						<?php the_title( '<h3 class="team-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">','</a></h3>'); ?>

						<?php
						$social_icons = ff_multipurpose_gtm( 'ff_multipurpose_team_custom_social_' . $ff_multipurpose_loop->current_post );

						if ( $social_icons ) : ?>
						<div class="social-nav">
							<ul>
							<?php foreach ( explode( ',', $social_icons ) as $social_icon  ): ?>
								<li><a href="<?php echo esc_url( $social_icon ); ?>" target="_blank"></a></li>
							<?php endforeach; ?>
							</ul>
						</div><!-- .social-nav -->
						<?php endif; ?>
					</div><!-- .team-text-wrap -->
				</div><!-- .team-block-inner -->
			</div><!-- .team-block-item -->
		<?php
		endwhile;
		?>
		</div><!-- .inner-wrapper -->
	</div><!-- .teams-section -->
<?php
endif;

wp_reset_postdata();
