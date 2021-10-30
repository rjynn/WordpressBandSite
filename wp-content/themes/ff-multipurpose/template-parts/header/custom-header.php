<?php
/**
 * Displays header site branding
 *
 * @package FF_Multipurpose
 */

$ff_multipurpose_enable = ff_multipurpose_gtm( 'ff_multipurpose_header_image_visibility' );

if ( ff_multipurpose_display_section( $ff_multipurpose_enable ) ) : ?>
<div id="custom-header">
	<?php is_header_video_active() && has_header_video() ? the_custom_header_markup() : ''; ?>

	<div class="custom-header-content">
		<div class="container">
			<?php ff_multipurpose_header_title(); ?>
		</div> <!-- .container -->
	</div>  <!-- .custom-header-content -->
</div>
<?php
endif;
