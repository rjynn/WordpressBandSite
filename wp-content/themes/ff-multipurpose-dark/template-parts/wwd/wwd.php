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

$ff_multipurpose_top_subtitle = ff_multipurpose_gtm( 'ff_multipurpose_wwd_section_top_subtitle' );
$ff_multipurpose_title        = ff_multipurpose_gtm( 'ff_multipurpose_wwd_section_title' );
$ff_multipurpose_subtitle     = ff_multipurpose_gtm( 'ff_multipurpose_wwd_section_subtitle' );
?>

<div id="wwd-section" class="section style-two">
	<div class="section-wwd wwd-layout-1">
		<div class="container">
			<?php if ( $ff_multipurpose_top_subtitle || $ff_multipurpose_title || $ff_multipurpose_subtitle ) : ?>
			<div class="section-title-wrap">
				<?php if ( $ff_multipurpose_top_subtitle ) : ?>
				<p class="section-top-subtitle"><?php echo esc_html( $ff_multipurpose_top_subtitle ); ?></p>
				<?php endif; ?>

				<?php if ( $ff_multipurpose_title ) : ?>
				<h2 class="section-title"><?php echo esc_html( $ff_multipurpose_title ); ?></h2>
				<?php endif; ?>

				<span class="divider"></span>
				<?php if ( $ff_multipurpose_subtitle ) : ?>
				<p class="section-subtitle"><?php echo esc_html( $ff_multipurpose_subtitle ); ?></p>
				<?php endif; ?>

			</div>
			<?php endif; ?>

			<?php get_template_part( 'template-parts/wwd/post-type' ); ?>
		</div><!-- .container -->
	</div><!-- .section-wwd  -->
</div><!-- .section -->
