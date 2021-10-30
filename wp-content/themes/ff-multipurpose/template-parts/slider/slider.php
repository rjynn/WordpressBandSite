<?php
/**
 * Template part for displaying Slider
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package FF_Multipurpose
 */

$ff_multipurpose_enable_slider = ff_multipurpose_gtm( 'ff_multipurpose_slider_visibility' );

if ( ! ff_multipurpose_display_section( $ff_multipurpose_enable_slider ) ) {
	return;
}

$ff_multipurpose_classes[] = 'section';
$ff_multipurpose_classes[] = 'no-padding';

if ( ff_multipurpose_gtm( 'ff_multipurpose_slider_overlay' ) ) {
	$ff_multipurpose_classes[] = 'overlay-enabled';
}

$ff_multipurpose_classes[] = 'style-one';

if ( ! ff_multipurpose_gtm( 'ff_multipurpose_slider_zoom' ) ) {
	$ff_multipurpose_classes[] = 'zoom-disabled';
}

$slider_zoom = ff_multipurpose_gtm( 'ff_multipurpose_slider_zoom' );
?>
<div id="slider-section" class="<?php echo esc_attr( implode( ' ', $ff_multipurpose_classes ) ) ; ?>">
	<div class="swiper-wrapper">
		<?php get_template_part( 'template-parts/slider/post', 'type' ); ?>
	</div><!-- .swiper-wrapper -->


	<div class="swiper-pagination"></div>
	<div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
</div><!-- .main-slider -->
