<?php
/**
 * Call To Action section
 *
 * This is the template for the content of Call To Action section
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */
if ( ! function_exists( 'corpo_digital_add_promotion_section' ) ) :
    /**
    * Add Call To Action section
    *
    *@since  Corpo Digital 1.0.0
    */
    function corpo_digital_add_promotion_section() {
        $options = corpo_digital_get_theme_options();
        
        // Check if Call To Action is enabled on frontpage
        $promotion_enable = apply_filters( 'corpo_digital_section_status', true, 'promotion_section_enable' );

        if ( true !== $promotion_enable ) {
            return false;
        }

        // Get Call To Action section details
        $section_details = array();
        $section_details = apply_filters( 'corpo_digital_filter_promotion_section_details', $section_details );
        if ( empty( $section_details ) ) {
            return;
        }

        // Render Call To Action section now.
        corpo_digital_render_promotion_section( $section_details[0] );
    }
endif;

if ( ! function_exists( 'corpo_digital_get_promotion_section_details' ) ) :
    /**
    * Call To Action section details.
    *
    * @since  Corpo Digital 1.0.0
    * @param array $input Call To Action section details.
    */
    function corpo_digital_get_promotion_section_details( $input ) {
        $options = corpo_digital_get_theme_options();

        $content = array();
        $page_id = ! empty( $options['promotion_content_page'] ) ? $options['promotion_content_page'] : '';
        $args = array(
            'post_type'             => 'page',
            'posts_per_page'        => 1,
            'p'                     => $page_id,
            'ignore_sticky_posts'   => true,
            );                    

        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['id']        = get_the_id();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['excerpt']   = corpo_digital_trim_content( 30 );

                // Push to the main array.
                array_push( $content, $page_post );
            endwhile;
        endif;
        wp_reset_postdata();

        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;

// Call To Action section content details.
add_filter( 'corpo_digital_filter_promotion_section_details', 'corpo_digital_get_promotion_section_details' );


if ( ! function_exists( 'corpo_digital_render_promotion_section' ) ) :
  /**
   * Start Call To Action section
   *
   * @return string Call To Action content
   * @since  Corpo Digital 1.0.0
   *
   */
   function corpo_digital_render_promotion_section( $content_details = array() ) {
        $options    = corpo_digital_get_theme_options();
        $btn_label  = $options['promotion_read_more'];

        if ( empty( $content_details ) ) {
            return;
        } ?>
        <div id="corpo_digital_promotion_section">
            <div id="promotion-section" class="relative page-section">
                <div class="wrapper">
                    <header class="entry-header">
                        <h2 class="entry-title"><?php echo esc_html($content_details['title']); ?></h2>
                    </header>

                    <div class="entry-content">
                        <p><?php echo wp_kses_post($content_details['excerpt']); ?></p>
                    </div><!-- .entry-content -->
                    <?php if ( !empty( $btn_label ) ): ?>
                        <div class="read-more">
                            <a href="<?php echo esc_url($content_details['url']); ?>" class="btn"><?php echo esc_html($btn_label); ?></a>
                        </div>
                    <?php endif; ?>
                </div><!-- .wrapper -->
            </div><!-- #promotion-section -->
        </div>
            
       
    <?php }
endif;