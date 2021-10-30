<?php
/**
 * Template part for displaying Service
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package FF_Multipurpose
 */

$ff_multipurpose_enable_team = ff_multipurpose_gtm( 'ff_multipurpose_team_visibility' );

if ( ! ff_multipurpose_display_section( $ff_multipurpose_enable_team ) ) {
	return;
}
?>
<div id="team-section" class="section style-one">
	<div class="section-teams">
		<div class="container">
			<?php ff_multipurpose_section_title( 'team' ); ?>

			<?php get_template_part( 'template-parts/team/post-type' ); ?>
		</div><!-- .container -->
	</div><!-- .section-teams  -->
</div><!-- .section -->
