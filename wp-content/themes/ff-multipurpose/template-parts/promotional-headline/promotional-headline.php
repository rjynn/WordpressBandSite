<?php
/**
 * Template part for displaying Hero Content
 *
 * @package FF_Multipurpose
 */

$ff_multipurpose_enable_promotional = ff_multipurpose_gtm( 'ff_multipurpose_promotional_headline_visibility' );

if ( ! ff_multipurpose_display_section( $ff_multipurpose_enable_promotional ) ) {
	return;
}

get_template_part( 'template-parts/promotional-headline/post-type' );
