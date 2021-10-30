<?php
/**
 * Template part for displaying Service
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package FF_Multipurpose
 */

$ff_multipurpose_enable_portfolio = ff_multipurpose_gtm( 'ff_multipurpose_portfolio_visibility' );

if ( ! ff_multipurpose_display_section( $ff_multipurpose_enable_portfolio ) ) {
	return;
}
?>
<div id="portfolio-section" class="section section-portfolio style-one">
	<div class="container">
		<?php ff_multipurpose_section_title( 'portfolio' ); ?>

		<?php get_template_part( 'template-parts/portfolio/post-type' ); ?>
	</div>
</div><!-- .section -->
