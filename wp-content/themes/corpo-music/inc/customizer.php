<?php

function corpo_music_customize_register( $wp_customize ) {

	class Corpo_Music_Switch_Control extends WP_Customize_Control{

		public $type = 'switch';

		public $on_off_label = array();

		public function __construct( $manager, $id, $args = array() ){
	        $this->on_off_label = $args['on_off_label'];
	        parent::__construct( $manager, $id, $args );
	    }

		public function render_content(){
	    ?>
		    <span class="customize-control-title">
				<?php echo esc_html( $this->label ); ?>
			</span>

			<?php if( $this->description ){ ?>
				<span class="description customize-control-description">
				<?php echo wp_kses_post( $this->description ); ?>
				</span>
			<?php } ?>

			<?php
				$switch_class = ( $this->value() == 'true' ) ? 'switch-on' : '';
				$on_off_label = $this->on_off_label;
			?>
			<div class="onoffswitch <?php echo esc_attr( $switch_class ); ?>">
				<div class="onoffswitch-inner">
					<div class="onoffswitch-active">
						<div class="onoffswitch-switch"><?php echo esc_html( $on_off_label['on'] ) ?></div>
					</div>

					<div class="onoffswitch-inactive">
						<div class="onoffswitch-switch"><?php echo esc_html( $on_off_label['off'] ) ?></div>
					</div>
				</div>	
			</div>
			<input <?php $this->link(); ?> type="hidden" value="<?php echo esc_attr( $this->value() ); ?>"/>
			<?php
	    }
	}

	class Corpo_Music_Dropdown_Chooser extends WP_Customize_Control{

		public $type = 'dropdown_chooser';

		public function render_content(){
			if ( empty( $this->choices ) )
	                return;
			?>
	            <label>
	                <span class="customize-control-title">
	                	<?php echo esc_html( $this->label ); ?>
	                </span>

	                <?php if($this->description){ ?>
		            <span class="description customize-control-description">
		            	<?php echo wp_kses_post($this->description); ?>
		            </span>
		            <?php } ?>

	                <select class="corpo-music-chosen-select" <?php $this->link(); ?>>
	                    <?php
	                    foreach ( $this->choices as $value => $label )
	                        echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . esc_html( $label ) . '</option>';
	                    ?>
	                </select>
	            </label>
			<?php
		}
	}

	class Corpo_Music_Customize_Horizontal_Line extends WP_Customize_Control {
		public $type = 'hr';

		public function render_content() {
			?>
			<div>
				<hr style="border: 1px dotted #72777c;" />
			</div>
			<?php
		}
	}

	class Corpo_Music_Multi_Input_Custom_Control extends WP_Customize_Control {
	
		public $type = 'multi-input';

	
		public $button_text;

	
		public function render_content() {
			?>
			<label class="customize_multi_input">
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<p><?php echo esc_html( $this->description ); ?></p>
				<input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize_multi_value_field" <?php $this->link(); ?> />
				<div class="customize_multi_fields">
					<div class="set">
						<input type="text" value="" class="customize_multi_single_field"/>
						<span class="customize_multi_remove_field"><span class="dashicons dashicons-no-alt"></span></span>
					</div>
				</div>
				<a href="#" class="button button-primary customize_multi_add_field"><?php echo esc_html( $this->button_text ); ?></a>
			</label>
			<?php
		}
	}


	class Corpo_Music_Multiple_Dropdown_Chooser extends WP_Customize_Control{
		public $type = 'dropdown_chooser';

		public function render_content(){
			if ( empty( $this->choices ) )
	                return;
			?>
	            <label>
	                <span class="customize-control-title">
	                	<?php echo esc_html( $this->label ); ?>
	                </span>

	                <?php if($this->description){ ?>
		            <span class="description customize-control-description">
		            	<?php echo wp_kses_post($this->description); ?>
		            </span>
		            <?php } ?>

	                <select class="corpo-music-chosen-select" <?php $this->link(); ?> multiple>
	                    <?php
	                    foreach ( $this->choices as $value => $label )
	                        echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . esc_html( $label ) . '</option>';
	                    ?>
	                </select>
	            </label>
			<?php
		}
	}



	// Add Playlist section
	$wp_customize->add_section( 'corpo_digital_playlist_section', array(
		'title'             => esc_html__( 'Playlist','corpo-music' ),
		'description'       => esc_html__( 'Playlist Section options.', 'corpo-music' ),
		'panel'             => 'corpo_digital_front_page_panel',
		'priority'			=> 161,
	) );

	// Playlist content enable control and setting
	$wp_customize->add_setting( 'corpo_music_playlist_section_enable', array(
		'default'			=> 	false,
		'sanitize_callback' => 'corpo_digital_sanitize_switch_control',
	) );

	$wp_customize->add_control( new Corpo_Music_Switch_Control( $wp_customize, 'corpo_music_playlist_section_enable', array(
		'label'             => esc_html__( 'Playlist Section Enable', 'corpo-music' ),
		'section'           => 'corpo_digital_playlist_section',
		'on_off_label' 		=> corpo_digital_switch_options(),
	) ) );

	// playlist title setting and control
	$wp_customize->add_setting( 'corpo_music_playlist_title', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'			=> '',
	) );

	$wp_customize->add_control( 'corpo_music_playlist_title', array(
		'label'           	=> esc_html__( 'Title', 'corpo-music' ),
		'section'        	=> 'corpo_digital_playlist_section',
		'active_callback' 	=> 'corpo_music_is_playlist_section_enable',
		'type'				=> 'text',
	) );


	// playlist subtitle setting and control
	$wp_customize->add_setting( 'corpo_music_playlist_subtitle', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'			=> '',
	) );

	$wp_customize->add_control( 'corpo_music_playlist_subtitle', array(
		'label'           	=> esc_html__( 'Sub Title', 'corpo-music' ),
		'section'        	=> 'corpo_digital_playlist_section',
		'active_callback' 	=> 'corpo_music_is_playlist_section_enable',
		'type'				=> 'text',
	) );


	$wp_customize->add_setting( 'corpo_music_playlist_bg_image', array(
		'sanitize_callback' => 'corpo_digital_sanitize_image'
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'corpo_music_playlist_bg_image',
			array(
			'label'       		=> esc_html__( 'Bg Image', 'corpo-music' ),
			'section'     		=> 'corpo_digital_playlist_section',
			'active_callback'	=> 'corpo_music_is_playlist_section_enable',
	) ) );


	// playlist image setting and control.
	$wp_customize->add_setting( 'corpo_music_playlist_image', array(
		'sanitize_callback' => 'corpo_digital_sanitize_image'
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'corpo_music_playlist_image',
			array(
			'label'       		=> esc_html__( 'Featured Image', 'corpo-music' ),
			'section'     		=> 'corpo_digital_playlist_section',
			'active_callback'	=> 'corpo_music_is_playlist_section_enable',
	) ) );

	// playlist posts drop down chooser control and setting
	$wp_customize->add_setting( 'corpo_music_playlist_content', array(
		'sanitize_callback' => 'corpo_music_sanitize_array_int',
	) );

	$wp_customize->add_control( new Corpo_Music_Multiple_Dropdown_Chooser( $wp_customize, 'corpo_music_playlist_content', array(
		'label'             => esc_html__( 'Select Multiple Audios', 'corpo-music' ),
		'description'       => esc_html__( 'Hold ctrl btn to select multuple item', 'corpo-music' ),
		'section'           => 'corpo_digital_playlist_section',
		'choices'			=> corpo_music_audio_choices(),
		'active_callback'	=> 'corpo_music_is_playlist_section_enable',
	) ) );


	// Add Team section
	$wp_customize->add_section( 'corpo_digital_team_section', array(
		'title'             => esc_html__( 'Team','corpo-music' ),
		'description'       => esc_html__( 'Team Section options.', 'corpo-music' ),
		'panel'             => 'corpo_digital_front_page_panel',
		'priority'			=> 162,
	) );

	// Team content enable control and setting
	$wp_customize->add_setting( 'corpo_music_team_section_enable', array(
		'default'			=> 	false,
		'sanitize_callback' => 'corpo_digital_sanitize_switch_control',
	) );

	$wp_customize->add_control( new Corpo_Music_Switch_Control( $wp_customize, 'corpo_music_team_section_enable', array(
		'label'             => esc_html__( 'Team Section Enable', 'corpo-music' ),
		'section'           => 'corpo_digital_team_section',
		'on_off_label' 		=> corpo_digital_switch_options(),
	) ) );


	// team title setting and control
	$wp_customize->add_setting( 'corpo_music_team_title', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'			=> '',
	) );

	$wp_customize->add_control( 'corpo_music_team_title', array(
		'label'           	=> esc_html__( 'Section Title', 'corpo-music' ),
		'section'        	=> 'corpo_digital_team_section',
		'active_callback' 	=> 'corpo_music_is_team_section_enable',
		'type'				=> 'text',
	) );


	// team description setting and control
	$wp_customize->add_setting( 'corpo_music_team_sub_title', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'			=> '',
	) );

	$wp_customize->add_control( 'corpo_music_team_sub_title', array(
		'label'           	=> esc_html__( 'Section Sub Title', 'corpo-music' ),
		'section'        	=> 'corpo_digital_team_section',
		'active_callback' 	=> 'corpo_music_is_team_section_enable',
		'type'				=> 'text',
	) );


	for ( $i = 1; $i <= 3; $i++ ) :
		// team pages drop down chooser control and setting
		$wp_customize->add_setting( 'corpo_music_team_content_page_' . $i, array(
			'sanitize_callback' => 'corpo_digital_sanitize_page',
		) );

		$wp_customize->add_control( new Corpo_Music_Dropdown_Chooser( $wp_customize, 'corpo_music_team_content_page_' . $i, array(
			'label'             => sprintf( esc_html__( 'Select Page %d', 'corpo-music' ), $i ),
			'section'           => 'corpo_digital_team_section',
			'choices'			=> corpo_digital_page_choices(),
			'active_callback'	=> 'corpo_music_is_team_section_enable',
		) ) );

		// team position setting and control
		$wp_customize->add_setting( 'corpo_music_team_position_' . $i, array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'corpo_music_team_position_' . $i, array(
			'label'           	=> sprintf( esc_html__( 'Position %d', 'corpo-music' ), $i ),
			'section'        	=> 'corpo_digital_team_section',
			'active_callback' 	=> 'corpo_music_is_team_section_enable',
			'type'				=> 'text',
		) );

	

		// team multiple input setting and control
		$wp_customize->add_setting( 'corpo_music_team_social_'. $i, array(
			'sanitize_callback' => 'sanitize_text_field'
		) );

		$wp_customize->add_control( new Corpo_Music_Multi_Input_Custom_Control( $wp_customize, 'corpo_music_team_social_'. $i,
			array(
				'label'           => sprintf( esc_html__( 'Social Link %d', 'corpo-music' ), $i ),
				'button_text'	  => esc_html__( 'Add Social Link', 'corpo-music' ),
				'section'         => 'corpo_digital_team_section',
				'active_callback' => 'corpo_music_is_team_section_enable',
				'type'			  => 'multi-input'
		) ) );

		// team hr setting and control
		$wp_customize->add_setting( 'corpo_music_team_hr_'. $i, array(
			'sanitize_callback' => 'corpo_digital_sanitize_html'
		) );

		$wp_customize->add_control( new Corpo_Music_Customize_Horizontal_Line( $wp_customize, 'corpo_music_team_hr_'. $i,
			array(
				'section'         => 'corpo_digital_team_section',
				'active_callback' => 'corpo_music_is_team_section_enable',
				'type'			  => 'hr'
		) ) );
	endfor;

	// Add event section
	$wp_customize->add_section( 'corpo_digital_event_section', array(
		'title'             => esc_html__( 'Event','corpo-music' ),
		'description'       => esc_html__( 'Event Section options.', 'corpo-music' ),
		'panel'             => 'corpo_digital_front_page_panel',
		'priority'			=> 163,
	) );

	// event content enable control and setting
	$wp_customize->add_setting( 'corpo_music_event_section_enable', array(
		'default'			=> 	false,
		'sanitize_callback' => 'corpo_digital_sanitize_switch_control',
	) );

	$wp_customize->add_control( new Corpo_Music_Switch_Control( $wp_customize, 'corpo_music_event_section_enable', array(
		'label'             => esc_html__( 'event Section Enable', 'corpo-music' ),
		'section'           => 'corpo_digital_event_section',
		'on_off_label' 		=> corpo_digital_switch_options(),
	) ) );


	$wp_customize->add_setting( 'corpo_music_event_bg_image', array(
		'sanitize_callback' => 'corpo_digital_sanitize_image'
	) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'corpo_music_event_bg_image',
			array(
			'label'       		=> esc_html__( 'Bg Image', 'corpo-music' ),
			'section'     		=> 'corpo_digital_event_section',
			'active_callback'	=> 'corpo_music_is_event_section_enable',
	) ) );

	// event title setting and control
	$wp_customize->add_setting( 'corpo_music_event_title', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'			=> '',
	) );

	$wp_customize->add_control( 'corpo_music_event_title', array(
		'label'           	=> esc_html__( 'Section Title', 'corpo-music' ),
		'section'        	=> 'corpo_digital_event_section',
		'active_callback' 	=> 'corpo_music_is_event_section_enable',
		'type'				=> 'text',
	) );


	// event description setting and control
	$wp_customize->add_setting( 'corpo_music_event_sub_title', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'			=> '',
	) );

	$wp_customize->add_control( 'corpo_music_event_sub_title', array(
		'label'           	=> esc_html__( 'Section Sub Title', 'corpo-music' ),
		'section'        	=> 'corpo_digital_event_section',
		'active_callback' 	=> 'corpo_music_is_event_section_enable',
		'type'				=> 'text',
	) );

	// event title setting and control
	$wp_customize->add_setting( 'corpo_music_event_btn_label', array(
		'sanitize_callback' => 'sanitize_text_field',
		'default'			=> '',
	) );

	$wp_customize->add_control( 'corpo_music_event_btn_label', array(
		'label'           	=> esc_html__( 'Section Title', 'corpo-music' ),
		'section'        	=> 'corpo_digital_event_section',
		'active_callback' 	=> 'corpo_music_is_event_section_enable',
		'type'				=> 'text',
	) );



	for ( $i = 1; $i <= 5; $i++ ) :
		// event pages drop down chooser control and setting
		$wp_customize->add_setting( 'corpo_music_event_content_page_' . $i, array(
			'sanitize_callback' => 'corpo_digital_sanitize_page',
		) );

		$wp_customize->add_control( new Corpo_Music_Dropdown_Chooser( $wp_customize, 'corpo_music_event_content_page_' . $i, array(
			'label'             => sprintf( esc_html__( 'Select Page %d', 'corpo-music' ), $i ),
			'section'           => 'corpo_digital_event_section',
			'choices'			=> corpo_digital_page_choices(),
			'active_callback'	=> 'corpo_music_is_event_section_enable',
		) ) );

		// event position setting and control
		$wp_customize->add_setting( 'corpo_music_event_location_' . $i, array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'corpo_music_event_location_' . $i, array(
			'label'           	=> sprintf( esc_html__( 'Event Location %d', 'corpo-music' ), $i ),
			'section'        	=> 'corpo_digital_event_section',
			'active_callback' 	=> 'corpo_music_is_event_section_enable',
			'type'				=> 'text',
		) );

		// event position setting and control
		$wp_customize->add_setting( 'corpo_music_event_date_' . $i, array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'corpo_music_event_date_' . $i, array(
			'label'           	=> sprintf( esc_html__( 'Event Date %d', 'corpo-music' ), $i ),
			'section'        	=> 'corpo_digital_event_section',
			'active_callback' 	=> 'corpo_music_is_event_section_enable',
			'type'				=> 'text',
		) );

		// event position setting and control
		$wp_customize->add_setting( 'corpo_music_event_time_' . $i, array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'corpo_music_event_time_' . $i, array(
			'label'           	=> sprintf( esc_html__( 'Event Time %d', 'corpo-music' ), $i ),
			'section'        	=> 'corpo_digital_event_section',
			'active_callback' 	=> 'corpo_music_is_event_section_enable',
			'type'				=> 'text',
		) );

		// event hr setting and control
		$wp_customize->add_setting( 'corpo_music_event_hr_'. $i, array(
			'sanitize_callback' => 'corpo_digital_sanitize_html'
		) );

		$wp_customize->add_control( new Corpo_Music_Customize_Horizontal_Line( $wp_customize, 'corpo_music_event_hr_'. $i,
			array(
				'section'         => 'corpo_digital_event_section',
				'active_callback' => 'corpo_music_is_event_section_enable',
				'type'			  => 'hr'
		) ) );
	endfor;





}
add_action( 'customize_register', 'corpo_music_customize_register' );


function corpo_music_sanitize_array_int( $input ) {

	$links = array_map( 'absint', $input );

	return $links;
}

function corpo_music_is_playlist_section_enable( $control ) {
	return ( $control->manager->get_setting( 'corpo_music_playlist_section_enable' )->value() );
}


function corpo_music_is_team_section_enable( $control ) {
	return ( $control->manager->get_setting( 'corpo_music_team_section_enable' )->value() );
}


function corpo_music_is_event_section_enable( $control ) {
	return ( $control->manager->get_setting( 'corpo_music_event_section_enable' )->value() );
}


