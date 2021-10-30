<?php
/**
 * Template part for displaying Service
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package FF_Multipurpose
 */

$ff_multipurpose_enable = ff_multipurpose_gtm( 'ff_multipurpose_featured_content_visibility' );

if ( ! ff_multipurpose_display_section( $ff_multipurpose_enable ) ) {
	return;
}

$ff_multipurpose_top_title = ff_multipurpose_gtm( 'ff_multipurpose_featured_content_section_top_subtitle' );
$ff_multipurpose_title        = ff_multipurpose_gtm( 'ff_multipurpose_featured_content_section_title' );
$ff_multipurpose_subtitle     = ff_multipurpose_gtm( 'ff_multipurpose_featured_content_section_subtitle' );
?>

<div id="featured-content-section" class="section style-two">
	<div class="section-latest-posts">
		<div class="container">
			<?php if ( $ff_multipurpose_top_title || $ff_multipurpose_title || $ff_multipurpose_subtitle ) : ?>
			<div class="section-title-wrap">
				<?php if ( $ff_multipurpose_top_title ) : ?>
				<p class="section-top-subtitle"><?php echo esc_html( $ff_multipurpose_top_title ); ?></p>
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

			<?php get_template_part( 'template-parts/featured-content/post-type' ); ?>
			</div><!-- .container -->
	</div><!-- .section-latest-posts -->
</div><!-- .section -->
