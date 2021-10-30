<?php
/**
 * Template part for displaying Hero Content
 *
 * @package FF_Multipurpose
 */

$ff_multipurpose_enable = ff_multipurpose_gtm( 'ff_multipurpose_hero_content_visibility' );

if ( ! ff_multipurpose_display_section( $ff_multipurpose_enable ) ) {
	return;
}

get_template_part( 'template-parts/hero-content/content-hero' );
