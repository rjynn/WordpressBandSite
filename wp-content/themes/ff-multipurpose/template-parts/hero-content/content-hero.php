<?php
/**
 * Template part for displaying Hero Content
 *
 * @package FF_Multipurpose
 */

if ( ff_multipurpose_gtm( 'ff_multipurpose_hero_content_page' ) ) {
	$ff_multipurpose_args = array(
		'page_id' => absint( ff_multipurpose_gtm( 'ff_multipurpose_hero_content_page' ) ),
	);
}

// If $ff_multipurpose_args is empty return false
if ( empty( $ff_multipurpose_args ) ) {
	return;
}

$ff_multipurpose_args['posts_per_page'] = 1;

$ff_multipurpose_loop = new WP_Query( $ff_multipurpose_args );

while ( $ff_multipurpose_loop->have_posts() ) :
	$ff_multipurpose_loop->the_post();

	$subtitle      = ff_multipurpose_gtm( 'ff_multipurpose_hero_content_custom_subtitle' );
	?>

	<div id="hero-content-section" class="hero-content-section section content-position-right default">
		<div class="section-featured-page">
			<div class="container">
				<div class="row">
					<?php if ( has_post_thumbnail() ) : ?>
					<div class="ff-grid-6 featured-page-thumb">
						<?php the_post_thumbnail( 'ff-multipurpose-hero', array( 'class' => 'alignnone' ) );?>
					</div>
					<?php endif; ?>

					<!-- .ff-grid-6 -->
					<div class="ff-grid-6 featured-page-content">
						<div class="featured-page-section">
							<div class="section-title-wrap">
								<?php if ( $subtitle ) : ?>
								<p class="section-top-subtitle"><?php echo esc_html( $subtitle ); ?></p>
								<?php endif; ?>

								<?php the_title( '<h2 class="section-title">', '</h2>' ); ?>

								<span class="divider"></span>
							</div>

							<div class="featured-info">
								<?php the_excerpt(); ?>
							</div><!-- .featured-info -->
						</div><!-- .featured-page-section -->
					</div><!-- .ff-grid-6 -->
				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .section-featured-page -->
	</div><!-- .section -->
<?php
endwhile;

wp_reset_postdata();
