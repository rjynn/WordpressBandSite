<?php
/**
 * Template part for displaying Hero Content
 *
 * @package FF_Multipurpose
 */

if ( ff_multipurpose_gtm( 'ff_multipurpose_promotional_headline_page' ) ) {
	$ff_multipurpose_args = array(
		'page_id' => absint( ff_multipurpose_gtm( 'ff_multipurpose_promotional_headline_page' ) ),
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
	$overlay  = ff_multipurpose_gtm( 'ff_multipurpose_promotional_headline_overlay' ) ? ' overlay-enabled' : '';
	?>

	<div id="promotional-headline-section" class="section promotional-headline-section text-aligncenter<?php echo esc_attr( $overlay ); ?>" <?php echo has_post_thumbnail() ? 'style="background-image: url( ' .esc_url( get_the_post_thumbnail_url() ) . ' )"' : ''; ?>>
	<div class="promotion-inner-wrapper section-promotion">
		<div class="container">
			<div class="promotion-content">
				<div class="promotion-description">
					<?php the_title( '<h2>', '</h2>' ); ?>

					<?php the_excerpt(); ?>
				</div><!-- .promotion-description -->
			</div><!-- .promotion-content -->
		</div><!-- .container -->
	</div><!-- .promotion-inner-wrapper" -->
</div><!-- .section -->
<?php
endwhile;

wp_reset_postdata();
