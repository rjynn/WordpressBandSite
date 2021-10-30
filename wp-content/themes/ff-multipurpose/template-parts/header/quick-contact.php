<?php
/**
 * Header Search
 *
 * @package FF_Multipurpose
 */

$ff_multipurpose_phone      = ff_multipurpose_gtm( 'ff_multipurpose_header_phone' );
$ff_multipurpose_email      = ff_multipurpose_gtm( 'ff_multipurpose_header_email' );
$ff_multipurpose_address    = ff_multipurpose_gtm( 'ff_multipurpose_header_address' );
$ff_multipurpose_open_hours = ff_multipurpose_gtm( 'ff_multipurpose_header_open_hours' );

if ( $ff_multipurpose_phone || $ff_multipurpose_email || $ff_multipurpose_address || $ff_multipurpose_open_hours ) : ?>
	<div class="inner-quick-contact">
		<ul>
			<?php if ( $ff_multipurpose_phone ) : ?>
				<li class="quick-call">
					<span><?php esc_html_e( 'Phone', 'ff-multipurpose' ); ?></span><a href="tel:<?php echo preg_replace( '/\s+/', '', esc_attr( $ff_multipurpose_phone ) ); ?>"><?php echo esc_html( $ff_multipurpose_phone ); ?></a> </li>
			<?php endif; ?>

			<?php if ( $ff_multipurpose_email ) : ?>
				<li class="quick-email"><span><?php esc_html_e( 'Email', 'ff-multipurpose' ); ?></span><a href="<?php echo esc_url( 'mailto:' . esc_attr( antispambot( $ff_multipurpose_email ) ) ); ?>"><?php echo esc_html( antispambot( $ff_multipurpose_email ) ); ?></a> </li>
			<?php endif; ?>

			<?php if ( $ff_multipurpose_address ) : ?>
				<li class="quick-address"><span><?php esc_html_e( 'Address', 'ff-multipurpose' ); ?></span><?php echo esc_html( $ff_multipurpose_address ); ?></li>
			<?php endif; ?>

			<?php if ( $ff_multipurpose_open_hours ) : ?>
				<li class="quick-open-hours"><span><?php esc_html_e( 'Open Hours', 'ff-multipurpose' ); ?></span><?php echo esc_html( $ff_multipurpose_open_hours ); ?></li>
			<?php endif; ?>
		</ul>
	</div><!-- .inner-quick-contact -->
<?php endif; ?>

