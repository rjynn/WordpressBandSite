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
?>
<div id="featured-content-section" class="section style-one">
	<div class="section-latest-posts">
		<div class="container">
			<?php ff_multipurpose_section_title( 'featured_content' ); ?>

			<?php get_template_part( 'template-parts/featured-content/post-type' ); ?>

			<?php
			$ff_multipurpose_button_text   = ff_multipurpose_gtm( 'ff_multipurpose_featured_content_button_text' );
			$ff_multipurpose_button_link   = ff_multipurpose_gtm( 'ff_multipurpose_featured_content_button_link' );
			$ff_multipurpose_button_target = ff_multipurpose_gtm( 'ff_multipurpose_featured_content_button_target' ) ? '_blank' : '_self';

			if ( $ff_multipurpose_button_text ) : ?>
				<div class="more-wrapper clear-fix">
					<a href="<?php echo esc_url($ff_multipurpose_button_link); ?>" class="ff-button" target="<?php echo esc_attr($ff_multipurpose_button_target); ?>"><?php echo esc_html($ff_multipurpose_button_text); ?></a>
				</div><!-- .more-wrapper -->
			<?php endif; ?>
			</div><!-- .container -->
		</div><!-- .latest-posts-section -->
	</div><!-- .section-latest-posts -->

