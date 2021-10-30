<?php
/**
 * Template part for displaying Service
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package FF_Multipurpose
 */

$ff_multipurpose_logo = ff_multipurpose_gtm( 'ff_multipurpose_associate_logo_visibility' );

if ( ! ff_multipurpose_display_section( $ff_multipurpose_logo ) ) {
	return;
}
?>
<div id="associate-logo-section" class="section">
	<div class="associate-logo-section">
		<div class="container">
			<?php ff_multipurpose_section_title( 'associate_logo' ); ?>

			<?php get_template_part( 'template-parts/associate-logo/post-type' ); ?>
		</div><!-- .container -->
	</div><!-- .associate-logo-section -->
</div><!-- .section -->
