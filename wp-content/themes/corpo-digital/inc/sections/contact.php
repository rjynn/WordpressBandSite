<?php
/**
 * Banner section
 *
 * This is the template for the content of contact section
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */
if ( ! function_exists( 'corpo_digital_add_contact_section' ) ) :
    /**
    * Add contact section
    *
    *@since  Corpo Digital 1.0.0
    */
    function corpo_digital_add_contact_section() {
    	$options = corpo_digital_get_theme_options();
        // Check if contact is enabled on frontpage
        $contact_enable = apply_filters( 'corpo_digital_section_status', true, 'contact_section_enable' );

        if ( true !== $contact_enable ) {
            return false;
        }
        // Get contact section details
        $section_details = array();
        $section_details = apply_filters( 'corpo_digital_filter_contact_section_details', $section_details );
        if ( empty( $section_details ) ) {
            return ;
        }

        // Render contact section now.
        corpo_digital_render_contact_section( $section_details );
    }
endif;

if ( ! function_exists( 'corpo_digital_get_contact_section_details' ) ) :
    /**
    * contact section details.
    *
    * @since  Corpo Digital 1.0.0
    * @param array $input contact section details.
    */
    function corpo_digital_get_contact_section_details( $input ) {
        $options = corpo_digital_get_theme_options();

        $content = array();
        $content['contact_section_shortcode']   = (!empty($options['contact_section_shortcode'])) ? $options['contact_section_shortcode'] : '';
        $content['contact_section_title']       = (!empty($options['contact_section_title'])) ? $options['contact_section_title'] : esc_html__('Stay In Touch!!', 'corpo-digital');
        $content['contact_section_subtitle']    = (!empty($options['contact_section_subtitle'])) ? $options['contact_section_subtitle'] : esc_html__('CONTACT US', 'corpo-digital');

        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// contact section content details.
add_filter( 'corpo_digital_filter_contact_section_details', 'corpo_digital_get_contact_section_details' );


if ( ! function_exists( 'corpo_digital_render_contact_section' ) ) :
  /**
   * Start contact section
   *
   * @return string contact content
   * @since  Corpo Digital 1.0.0
   *
   */
   function corpo_digital_render_contact_section( $content_details = array() ) {
        $options        = corpo_digital_get_theme_options();
        
        if ( empty( $content_details ) ) {
            return;
        } ?>
        <div id="corpo_digital_contact_section">
            <div id="contact-section" class="relative page-section">
                <div class="wrapper">
                    <div class="section-header-wrapper">
                        <div class="section-header">
                            <p class="section-subtitle"><?php echo esc_html( $content_details['contact_section_subtitle'] ); ?></p>
                            <h2 class="section-title"><?php echo esc_html( $content_details['contact_section_title'] ); ?></h2>
                        </div><!-- .section-header -->

                        <div class="contact-information">
                            <ul>
                                <li><i class="fa fa-map-marker"></i><span><?php echo esc_html($options['contact_section_address']); ?></span></li>
                                <li><i class="fa fa-phone"></i><span><?php echo esc_html($options['contact_section_phoneNumber']); ?></span></li>
                                <li><i class="fa fa-envelope"></i><span><?php echo esc_html($options['contact_section_email']); ?></span></li>
                            </ul>
                        </div><!-- .contact-information -->
                    </div><!-- .section-header-wrapper -->

                    <div class="section-content">
                        <?php echo do_shortcode( wp_kses_post( $content_details['contact_section_shortcode'] ) );  ?>
                    </div><!-- .section-content -->
                </div><!-- .wrapper -->
            </div><!-- #contact-section -->
        </div>  
        <?php 
    }    
endif; ?>
