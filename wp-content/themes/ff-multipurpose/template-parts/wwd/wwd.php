<?php
/**
 * Template part for displaying Service
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package FF_Multipurpose
 */

$ff_multipurpose_enable_wwd = ff_multipurpose_gtm( 'ff_multipurpose_wwd_visibility' );

if ( ! ff_multipurpose_display_section( $ff_multipurpose_enable_wwd ) ) {
	return;
}
?>
<div id="wwd-section" class="section style-one">
	<div class="section-wwd">
		<div class="container">
			<?php ff_multipurpose_section_title( 'wwd' ); ?>

			<?php get_template_part( 'template-parts/wwd/post-type' ); ?>
		</div><!-- .container -->
	</div><!-- .section-wwd  -->
</div><!-- .section -->
