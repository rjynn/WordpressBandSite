<?php
/**
 * Reset options
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */

/**
* Reset section
*/
// Add reset enable section
$wp_customize->add_section( 'corpo_digital_reset_section', array(
	'title'             => esc_html__('Reset all settings','corpo-digital'),
	'description'       => esc_html__( 'Caution: All settings will be reset to default. Refresh the page after clicking Save & Publish.', 'corpo-digital' ),
) );

// Add reset enable setting and control.
$wp_customize->add_setting( 'corpo_digital_theme_options[reset_options]', array(
	'default'           => $options['reset_options'],
	'sanitize_callback' => 'corpo_digital_sanitize_checkbox',
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'corpo_digital_theme_options[reset_options]', array(
	'label'             => esc_html__( 'Check to reset all settings', 'corpo-digital' ),
	'section'           => 'corpo_digital_reset_section',
	'type'              => 'checkbox',
) );
