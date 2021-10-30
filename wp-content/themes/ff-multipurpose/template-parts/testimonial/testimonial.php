<?php
/**
 * Template part for displaying Service
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package FF_Multipurpose
 */

$ff_multipurpose_enable_testimonial = ff_multipurpose_gtm( 'ff_multipurpose_testimonial_visibility' );

if ( ! ff_multipurpose_display_section( $ff_multipurpose_enable_testimonial ) ) {
	return;
}
?>

<div id="testimonial-section" class="section dark-background">
	<div class="section-testimonial testimonial-layout-1">
		<div class="container">
			<?php ff_multipurpose_section_title( 'testimonial' ); ?>

			<?php get_template_part( 'template-parts/testimonial/post-type' ); ?>
		</div><!-- .container -->
	</div><!-- .section-testimonial  -->
</div><!-- .section -->
