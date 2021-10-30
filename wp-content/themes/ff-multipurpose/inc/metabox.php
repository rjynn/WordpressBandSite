<?php
/**
 * The template for displaying meta box in page/post
 *
 * This adds Select Sidebar, Header Featured Image Options, Single Page/Post Image
 * This is only for the design purpose and not used to save any content
 *
 * @package FF_Multipurpose
 */

/**
 * Register meta box(es).
 */
function ff_multipurpose_register_meta_boxes() {
    add_meta_box( 'ff-multipurpose-sidebar-options', esc_html__( 'Select Sidebar', 'ff-multipurpose' ), 'ff_multipurpose_display_sidebar_options', array( 'post', 'page' ), 'side' );

    add_meta_box( 'ff-multipurpose-featured-image-options', esc_html__( 'Featured Image', 'ff-multipurpose' ), 'ff_multipurpose_display_featured_image_options', array( 'post', 'page' ), 'side' );
}
add_action( 'add_meta_boxes', 'ff_multipurpose_register_meta_boxes' );
 
/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function ff_multipurpose_display_sidebar_options( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'ff_multipurpose_custom_meta_box_nonce' );

	$sidebar_options = array(
		'default-sidebar'        => esc_html__( 'Default Sidebar', 'ff-multipurpose' ),
		'optional-sidebar-one'   => esc_html__( 'Optional Sidebar One', 'ff-multipurpose' ),
		'optional-sidebar-two'   => esc_html__( 'Optional Sidebar Two', 'ff-multipurpose' ),
		'optional-sidebar-three' => esc_html__( 'Optional Sidebar three', 'ff-multipurpose' ),
	);

	$meta_option = get_post_meta( $post->ID, 'ff-multipurpose-sidebar-option', true );

	if ( empty( $meta_option ) ){
		$meta_option = 'default-sidebar';
	}
	
	?>
	<select name="ff-multipurpose-sidebar-option"> 
		<?php
		foreach ( $sidebar_options as $field => $label ) {
		?>
			<option value="<?php echo esc_attr( $field ); ?>" <?php selected( $field, $meta_option ); ?>><?php echo esc_html( $label ); ?></option>
		<?php
		} // endforeach.
		?>
	</select>
	<?php
}

/**
 * Meta box display callback.
 *
 * @param WP_Post $post Current post object.
 */
function ff_multipurpose_display_featured_image_options( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'ff_multipurpose_custom_meta_box_nonce' );

	$featured_image_options = array(
		'default'                   => esc_html__( 'Default', 'ff-multipurpose' ),
		'disabled'                  => esc_html__( 'Disabled', 'ff-multipurpose' ),
		'post-thumbnail'            => esc_html__( 'Post Thumbnail (470x470)', 'ff-multipurpose' ),
		'ff-multipurpose-slider' => esc_html__( 'Slider Image (1920x954)', 'ff-multipurpose' ),
		'full'                      => esc_html__( 'Original Image Size', 'ff-multipurpose' ),
	);

	$meta_option = get_post_meta( $post->ID, 'ff-multipurpose-featured-image', true );

	if ( empty( $meta_option ) ){
		$meta_option = 'default';
	}
	
	?>
	<select name="ff-multipurpose-featured-image"> 
		<?php
		foreach ( $featured_image_options as $field => $label ) {
		?>
			<option value="<?php echo esc_attr( $field ); ?>" <?php selected( $field, $meta_option ); ?>><?php echo esc_html( $label ); ?></option>
		<?php
		} // endforeach.
		?>
	</select>
	<?php
}
 
/**
 * Save meta box content.
 *
 * @param int $post_id Post ID
 */
function ff_multipurpose_save_meta_box( $post_id ) {
	global $post_type;

	$post_type_object = get_post_type_object( $post_type );

	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                      // Check Autosave
	|| ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )        // Check Revision
	|| ( ! in_array( $post_type, array( 'page', 'post' ) ) )                  // Check if current post type is supported.
	|| ( ! check_admin_referer( basename( __FILE__ ), 'ff_multipurpose_custom_meta_box_nonce') )    // Check nonce - Security
	|| ( ! current_user_can( $post_type_object->cap->edit_post, $post_id ) ) )  // Check permission
	{
	  return $post_id;
	}

	$fields = array(
		'ff-multipurpose-sidebar-option',
		'ff-multipurpose-featured-image',
	);

	foreach ( $fields as $field ) {
		$new = $_POST[ $field ];

		delete_post_meta( $post_id, $field );

		if ( '' == $new || array() == $new ) {
			return;
		} else {
			if ( ! update_post_meta ( $post_id, $field, sanitize_key( $new ) ) ) {
				add_post_meta( $post_id, $field, sanitize_key( $new ), true );
			}
		}
	} // end foreach
}
add_action( 'save_post', 'ff_multipurpose_save_meta_box' );
