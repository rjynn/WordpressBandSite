<?php
/**
 * Header One Style Template
 *
 * @package FF_Multipurpose
 */
$ff_multipurpose_phone      = ff_multipurpose_gtm( 'ff_multipurpose_header_phone' );
$ff_multipurpose_email      = ff_multipurpose_gtm( 'ff_multipurpose_header_email' );
$ff_multipurpose_address    = ff_multipurpose_gtm( 'ff_multipurpose_header_address' );
$ff_multipurpose_open_hours = ff_multipurpose_gtm( 'ff_multipurpose_header_open_hours' );
?>
<div class="header-wrapper overlap-header">
	<?php if ( $ff_multipurpose_phone || $ff_multipurpose_email || $ff_multipurpose_address || $ff_multipurpose_open_hours || has_nav_menu( 'social' ) ) : ?>
	<div id="top-header" class="dark-top-header">
		<div class="site-top-header-mobile">
			<div class="container">
				<button id="header-top-toggle" class="header-top-toggle" aria-controls="header-top" aria-expanded="false">
					<i class="fas fa-bars"></i><span class="menu-label"> <?php esc_html_e( 'Top Bar', 'ff-multipurpose' ); ?></span>
				</button><!-- #header-top-toggle -->
				<div id="site-top-header-mobile-container">
					<?php if ( $ff_multipurpose_phone || $ff_multipurpose_email || $ff_multipurpose_address || $ff_multipurpose_open_hours ) : ?>
						<div id="quick-contact">
							<?php get_template_part( 'template-parts/header/quick-contact' ); ?>
						</div>
						<?php endif; ?>

						<?php if ( has_nav_menu( 'social' ) ): ?>
						<div id="top-social">
							<div class="social-nav">
								<nav id="social-primary-navigation" class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Social Links Menu', 'ff-multipurpose' ); ?>">
									<?php
										wp_nav_menu( array(
											'theme_location' => 'social',
											'menu_class'     => 'social-links-menu',
											'depth'          => 1,
											'link_before'    => '<span class="screen-reader-text">',
										) );
									?>
								</nav><!-- .social-navigation -->
							</div>
						</div><!-- #top-social -->
					<?php endif; ?>
					<?php
						$ff_multipurpose_button_text   = ff_multipurpose_gtm( 'ff_multipurpose_header_button_text' );
						$ff_multipurpose_button_link   = ff_multipurpose_gtm( 'ff_multipurpose_header_button_link' );
						$ff_multipurpose_button_target = ff_multipurpose_gtm( 'ff_multipurpose_header_button_target' ) ? '_blank' : '_self';

						if ( $ff_multipurpose_button_text ) :
						?>
						<a target="<?php echo esc_attr( $ff_multipurpose_button_target );?>" href="<?php echo esc_url( $ff_multipurpose_button_link );?>" class="ff-button header-button mobile-off"><?php echo esc_html( $ff_multipurpose_button_text );?></a>
					<?php endif; ?>
				</div><!-- #site-top-header-mobile-container-->
			</div><!-- .container -->
		</div><!-- .site-top-header-mobile -->
		<div class="site-top-header">
			<div class="container">
				<?php if ( $ff_multipurpose_phone || $ff_multipurpose_email || $ff_multipurpose_address || $ff_multipurpose_open_hours ) : ?>
				<div id="quick-contact" class="pull-left">
					<?php get_template_part( 'template-parts/header/quick-contact' ); ?>
				</div>
				<div class="top-head-right pull-right">
					<?php if ( has_nav_menu( 'social' ) ): ?>
					<div id="top-social" class="pull-left">
						<div class="social-nav">
							<nav id="social-primary-navigation" class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Social Links Menu', 'ff-multipurpose' ); ?>">
								<?php
									wp_nav_menu( array(
										'theme_location' => 'social',
										'menu_class'     => 'social-links-menu',
										'depth'          => 1,
										'link_before'    => '<span class="screen-reader-text">',
									) );
								?>
							</nav><!-- .social-navigation -->
						</div>
					</div><!-- #top-social -->
					<?php endif; ?>
					
					<?php
						$ff_multipurpose_button_text   = ff_multipurpose_gtm( 'ff_multipurpose_header_button_text' );
						$ff_multipurpose_button_link   = ff_multipurpose_gtm( 'ff_multipurpose_header_button_link' );
						$ff_multipurpose_button_target = ff_multipurpose_gtm( 'ff_multipurpose_header_button_target' ) ? '_blank' : '_self';

						if ( $ff_multipurpose_button_text ) :
						?>
						<a target="<?php echo esc_attr( $ff_multipurpose_button_target );?>" href="<?php echo esc_url( $ff_multipurpose_button_link );?>" class="ff-button header-button pull-right mobile-off pull-right"><?php echo esc_html( $ff_multipurpose_button_text );?></a>
						<?php endif; ?>
					</div><!-- .top-head-right -->
				<?php endif; ?>
			</div><!-- .container -->
		</div><!-- .site-top-header -->
	</div><!-- #top-header -->
	<?php endif; ?>

	<header id="masthead" class="site-header clear-fix">
		<div class="container">
			<div class="site-header-main">
				<div class="site-branding">
					<?php get_template_part( 'template-parts/header/site-branding' ); ?>
				</div><!-- .site-branding -->

				<div class="right-head pull-right">
					<div id="main-nav" class="pull-left">
						<?php get_template_part( 'template-parts/navigation/navigation-primary' ); ?>
					</div><!-- .main-nav -->

					<div class="head-search-cart-wrap pull-left">
						<div class="header-search pull-right">
							<?php get_template_part( 'template-parts/header/header-search' ); ?>
						</div><!-- .header-search -->
					</div><!-- .head-search-cart-wrap -->

				</div><!-- .right-head -->
			</div><!-- .site-header-main -->
		</div><!-- .container -->
	</header><!-- #masthead -->
</div><!-- .header-wrapper -->
