<?php
/**
 * Template for displaying search forms in FF Multipurpose
 *
 * @package FF_Multipurpose
 */
?>

<?php $search_text = ff_multipurpose_gtm( 'ff_multipurpose_search_text' ); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'ff-multipurpose' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php echo esc_attr( $search_text ); ?>" value="<?php the_search_query(); ?>" name="s" />
	</label>
	<input type="submit" class="search-submit" value="&#xf002;" />

</form>
