<?php
/**
 * FF Multipurpose Customizer Custom Controls
 *
 */

if ( class_exists( 'WP_Customize_Control' ) ) {
/**
	 * Image Radio Button Custom Control
	 */
	class FF_Multipurpose_Image_Radio_Button_Custom_Control extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'ff_multipurpose_image_radio_button';
		
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
		?>
			<div class="image_radio_button_control">
				<?php if( !empty( $this->label ) ) { ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>

				<?php foreach ( $this->choices as $key => $value ) { ?>
					<label class="radio-button-label">
						<input type="radio" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $key ); ?>" <?php $this->link(); ?> <?php checked( esc_attr( $key ), $this->value() ); ?>/>
						<img src="<?php echo esc_attr( $value['image'] ); ?>" alt="<?php echo esc_attr( $value['name'] ); ?>" title="<?php echo esc_attr( $value['name'] ); ?>" />
					</label>
				<?php	} ?>
			</div>
		<?php
		}
	}

	/**
	 * Simple Notice Custom Control
	 */
	class FF_Multipurpose_Simple_Notice_Custom_Control extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'ff_multipurpose_simple_notice';
		
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			$allowed_html = array(
				'a' => array(
					'href' => array(),
					'title' => array(),
					'class' => array(),
					'target' => array(),
				),
				'br' => array(),
				'em' => array(),
				'strong' => array(),
				'i' => array(
					'class' => array()
				),
				'span' => array(
					'class' => array(),
				),
				'code' => array(),
			);
		?>
			<hr>
			<div class="simple-notice-custom-control">
				<?php if( !empty( $this->label ) ) { ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php } ?>
				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo wp_kses( $this->description, $allowed_html ); ?></span>
				<?php } ?>
			</div>
		<?php
		}
	}

	/**
	 * Toggle Switch Custom Control
	 */
	class FF_Multipurpose_Toggle_Switch_Custom_control extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'ff_multipurpose_toggle_switch';
		
		/**
		 * Render the control in the customizer
		 */
		public function render_content(){
		?>
			<div class="toggle-switch-control">
				<div class="toggle-switch">
					<input type="checkbox" id="<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" class="toggle-switch-checkbox" value="<?php echo esc_attr( $this->value() ); ?>" <?php $this->link(); checked( $this->value() ); ?>>
					<label class="toggle-switch-label" for="<?php echo esc_attr( $this->id ); ?>">
						<span class="toggle-switch-inner"></span>
						<span class="toggle-switch-switch"></span>
					</label>
				</div>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>
			</div>
		<?php
		}
	}

		/**
	 * Dropdown Posts Custom Control
	 */
	class FF_Multipurpose_Dropdown_Posts_Custom_Control extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'ff_multipurpose_dropdown_posts';
		
		/**
		 * Posts
		 */
		private $posts = array();
		
		/**
		 * Constructor
		 */
		public function __construct( $manager, $id, $args = array(), $options = array() ) {
			parent::__construct( $manager, $id, $args );
			
			// Get our Posts
			$this->posts = FF_Multipurpose_Customizer_Utilities::get_posts_as_array( $this->input_attrs );
		}
		
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
		?>
			<div class="dropdown_posts_control">
				<?php if( !empty( $this->label ) ) { ?>
					<label for="<?php echo esc_attr( $this->id ); ?>" class="customize-control-title">
						<?php echo esc_html( $this->label ); ?>
					</label>
				<?php } ?>
				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>
				<select name="<?php echo esc_attr( $this->id ); ?>" id="<?php echo esc_attr( $this->id ); ?>" <?php $this->link(); ?>>
					<?php
						if ( ! empty( $this->posts ) ) {
							foreach ( $this->posts as $id => $title ) {
								printf( '<option value="%s" %s>%s</option>',
									absint( $id ),
									selected( $this->value(), $id, false ),
									esc_html( $title )
								);
							}
						}
					?>
				</select>
			</div>
		<?php
		}
	}

	/**
	 * Dropdown Select2 Custom Control
	 */
	class FF_Multipurpose_Dropdown_Select2_Custom_Control extends WP_Customize_Control {
		/**
		 * The type of control being rendered
		 */
		public $type = 'ff_multipurpose_dropdown_select2';
		
		/**
		 * The type of Select2 Dropwdown to display. Can be either a single select dropdown or a multi-select dropdown. Either false for true. Default = false
		 */
		private $multiselect = false;
		
		/**
		 * The Placeholder value to display. Select2 requires a Placeholder value to be set when using the clearall option. Default = 'Please select...'
		 */
		
		private $placeholder;
		
		/**
		 * Constructor
		 */
		public function __construct( $manager, $id, $args = array(), $options = array() ) {
			parent::__construct( $manager, $id, $args );
			// Check if this is a multi-select field
			if ( isset( $this->input_attrs['multiselect'] ) && $this->input_attrs['multiselect'] ) {
				$this->multiselect = true;
			}
			// Check if a placeholder string has been specified
			if ( isset( $this->input_attrs['placeholder'] ) && $this->input_attrs['placeholder'] ) {
				$this->placeholder = $this->input_attrs['placeholder'];
			}
		}
		
		/**
		 * Render the control in the customizer
		 */
		public function render_content() {
			$defaultValue = explode( ',', $this->value() );
		?>
			<div class="dropdown_select2_control">
				<?php if( !empty( $this->label ) ) { ?>
					<label for="<?php echo esc_attr( $this->id ); ?>" class="customize-control-title">
						<?php echo esc_html( $this->label ); ?>
					</label>
				<?php } ?>
				<?php if( !empty( $this->description ) ) { ?>
					<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
				<?php } ?>
				<input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" class="customize-control-dropdown-select2" value="<?php echo esc_attr( $this->value() ); ?>" name="<?php echo esc_attr( $this->id ); ?>" <?php $this->link(); ?> />
				<select name="select2-list-<?php echo ( $this->multiselect ? 'multi[]' : 'single' ); ?>" class="customize-control-select2" data-placeholder="<?php echo esc_attr( $this->placeholder ); ?>" <?php echo ( $this->multiselect ? 'multiple="multiple" ' : '' ); ?>>
					<?php
						if ( !$this->multiselect ) {
							// When using Select2 for single selection, the Placeholder needs an empty <option> at the top of the list for it to work (multi-selects dont need this)
							echo '<option></option>';
						}
						foreach ( $this->choices as $key => $value ) {
							if ( is_array( $value ) ) {
								echo '<optgroup label="' . esc_attr( $key ) . '">';
								foreach ( $value as $optgroupkey => $optgroupvalue ) {
									echo '<option value="' . esc_attr( $optgroupkey ) . '" ' . ( in_array( esc_attr( $optgroupkey ), $defaultValue ) ? 'selected="selected"' : '' ) . '>' . esc_attr( $optgroupvalue ) . '</option>';
								}
								echo '</optgroup>';
							}
							else {
								echo '<option value="' . esc_attr( $key ) . '" ' . selected( esc_attr( $key ), $defaultValue, false )  . '>' . esc_attr( $value ) . '</option>';
							}
						}
					?>
				</select>
			</div>
		<?php
		}
	}

	/**
	 * Upsell section
	 *
	 */
	class FF_Multipurpose_Upsell_Section extends WP_Customize_Section {
		/**
		 * The type of control being rendered
		 */
		public $type = 'ff_multipurpose_ff-multipurpose-upsell';
		
		/**
		 * The Upsell URL
		 */
		public $url = '';
		
		/**
		 * The background color for the control
		 */
		public $backgroundcolor = '';
		
		/**
		 * The text color for the control
		 */
		public $textcolor = '';
		
		/**
		 * Render the section, and the controls that have been added to it.
		 */
		protected function render() {
			$bkgrndcolor = !empty( $this->backgroundcolor ) ? esc_attr( $this->backgroundcolor ) : '#fff';
			$color = !empty( $this->textcolor ) ? esc_attr( $this->textcolor ) : '#555d66';
			?>
			<li id="accordion-section-<?php echo esc_attr( $this->id ); ?>" class="ff_multipurpose_upsell_section accordion-section control-section control-section-<?php echo esc_attr( $this->id ); ?> cannot-expand">
				<h3 class="upsell-section-title" <?php echo ' style="color:' . esc_attr( $color ) . ';border-left-color:' . esc_attr( $bkgrndcolor ) .';border-right-color:' . esc_attr( $bkgrndcolor ) .';"'; ?>>
					<a href="<?php echo esc_url( $this->url); ?>" target="_blank"<?php echo ' style="background-color:' . esc_attr( $bkgrndcolor ) . ';color:' . esc_attr( $color ) .';"'; ?>><?php echo esc_html( $this->title ); ?></a>
				</h3>
			</li>
			<?php
		}
	}

	/**
	 * Custom control for any note, use label as output description.
	 */
	class FF_Multipurpose_Note_Control extends WP_Customize_Control {
		public $type = 'ff_multipurpose_description';

		public function render_content() {
			echo '<hr><h2 class="description">' . wp_kses_post( $this->label ) . '</h2>';
		}
	}

	/**
	 * Switch sanitization
	 *
	 * @param  string		Switch value
	 * @return integer	Sanitized value
	 */
	if ( ! function_exists( 'ff_multipurpose_switch_sanitization' ) ) {
		function ff_multipurpose_switch_sanitization( $input ) {
			if ( true === $input ) {
				return 1;
			} else {
				return 0;
			}
		}
	}

	/**
	 * Radio Button and Select sanitization
	 *
	 * @param  string		Radio Button value
	 * @return integer	Sanitized value
	 */
	if ( ! function_exists( 'ff_multipurpose_radio_sanitization' ) ) {
		function ff_multipurpose_radio_sanitization( $input, $setting ) {
			//get the list of possible radio box or select options
		 $choices = $setting->manager->get_control( $setting->id )->choices;

			if ( array_key_exists( $input, $choices ) ) {
				return $input;
			} else {
				return $setting->default;
			}
		}
	}

	/**
	 * Text sanitization
	 *
	 * @param  string	Input to be sanitized
	 * @return string	Sanitized input
	 */
	if ( ! function_exists( 'ff_multipurpose_text_sanitization' ) ) {
		function ff_multipurpose_text_sanitization( $input ) {
			return sanitize_text_field( $input );
		}
	}

	/**
	 * Select sanitization callback example.
	 *
	 * - Sanitization: select
	 * - Control: select, radio
	 * 
	 * Sanitization callback for 'select' and 'radio' type controls. This callback sanitizes `$input`
	 * as a slug, and then validates `$input` against the choices defined for the control.
	 * 
	 * @see sanitize_key()               https://developer.wordpress.org/reference/functions/sanitize_key/
	 * @see $wp_customize->get_control() https://developer.wordpress.org/reference/classes/wp_customize_manager/get_control/
	 *
	 * @param string               $input   Slug to sanitize.
	 * @param WP_Customize_Setting $setting Setting instance.
	 * @return string Sanitized slug if it is a valid choice; otherwise, the setting default.
	 */
	function ff_multipurpose_sanitize_select( $input, $setting ) {
		
		// Ensure input is a slug.
		$input = sanitize_key( $input );
		
		// Get list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;
		
		// If the input is a valid key, return it; otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}

}
