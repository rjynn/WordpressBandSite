<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package FF_Multipurpose
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'ff-multipurpose-dark' ); ?></a>

	<?php
		get_template_part( 'template-parts/header/' . ff_multipurpose_gtm( 'ff_multipurpose_header_style' ) );
		get_template_part( 'template-parts/header/custom-header' );
		get_template_part( 'template-parts/header/breadcrumb' );
		get_template_part( 'template-parts/slider/slider' );
		get_template_part( 'template-parts/wwd/wwd' );
		get_template_part( 'template-parts/hero-content/hero-content' );
		get_template_part( 'template-parts/portfolio/portfolio' );
		get_template_part( 'template-parts/promotional-headline/promotional-headline' );
		get_template_part( 'template-parts/team/team' );
		get_template_part( 'template-parts/testimonial/testimonial' );
		get_template_part( 'template-parts/featured-content/featured-content' );
		get_template_part( 'template-parts/associate-logo/associate-logo' );
	?>

	<?php
	$show_content = ff_multipurpose_gtm( 'ff_multipurpose_show_homepage_content' );

	if ( $show_content || !is_front_page() ) : ?>
	<div id="content" class="site-content">
		<div class="container">
			<div class="row">
	<?php endif; ?>
