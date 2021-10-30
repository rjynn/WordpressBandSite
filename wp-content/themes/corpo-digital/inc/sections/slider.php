<?php
/**
 * Banner section
 *
 * This is the template for the content of slider section
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */
if ( ! function_exists( 'corpo_digital_add_slider_section' ) ) :
    /**
    * Add slider section
    *
    *@since  Corpo Digital 1.0.0
    */
    function corpo_digital_add_slider_section() {
    	$options = corpo_digital_get_theme_options();
        // Check if slider is enabled on frontpage
        $slider_enable = apply_filters( 'corpo_digital_section_status', true, 'slider_section_enable' );

        if ( true !== $slider_enable ) {
            return false;
        }
        // Get slider section details
        $section_details = array();
        $section_details = apply_filters( 'corpo_digital_filter_slider_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render slider section now.
        corpo_digital_render_slider_section( $section_details );
}

endif;

if ( ! function_exists( 'corpo_digital_get_slider_section_details' ) ) :
    /**
    * slider section details.
    *
    * @since  Corpo Digital 1.0.0
    * @param array $input slider section details.
    */
    function corpo_digital_get_slider_section_details( $input ) {
        $options = corpo_digital_get_theme_options();

        // Content type.
        $slider_count           = 3;
        
        $content = array();
        $page_ids = array();

        for ( $i = 1; $i <= $slider_count; $i++ ) {
            if ( ! empty( $options['slider_content_page_' . $i] ) )
                $page_ids[] = $options['slider_content_page_' . $i];
        }

        $args = array(
            'post_type'         => 'page',
            'post__in'          => ( array ) $page_ids,
            'posts_per_page'    => absint( $slider_count ),
            'orderby'           => 'post__in',
            );                    

        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            $i = 1;
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['id']        = get_the_id();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['excerpt']   = has_excerpt() ? get_the_excerpt() : corpo_digital_trim_content(15);
                $page_post['image']     = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'full' ) : get_template_directory_uri().'/assets/uploads/no-featured-image-600x450.jpg';

                // Push to the main array.
                array_push( $content, $page_post );
            endwhile;
            $i++;
        endif;
        wp_reset_postdata();

        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// slider section content details.
add_filter( 'corpo_digital_filter_slider_section_details', 'corpo_digital_get_slider_section_details' );


if ( ! function_exists( 'corpo_digital_render_slider_section' ) ) :
  /**
   * Start slider section
   *
   * @return string slider content
   * @since  Corpo Digital 1.0.0
   *
   */
   function corpo_digital_render_slider_section( $content_details = array() ) {
        $options = corpo_digital_get_theme_options();
        $slider_autoplay_enable = ($options['slider_autoplay_enable']) ? 'true' : 'false';
        $slider_btn_alt_url = (!empty($options['slider_btn_alt_url'])) ? $options['slider_btn_alt_url'] : '';

        if ( empty( $content_details ) ) {
            return;
        } ?>
        <div id="corpo_digital_slider_section">
             <div id="featured-slider-section" class="slider-section">
                <div class="featured-slider" data-slick='{"slidesToShow": 1, "slidesToScroll": 1, "infinite": true, "speed": 800, "dots": true, "arrows": false, "autoplay": <?php echo esc_attr($slider_autoplay_enable); ?>, "draggable": true, "fade": false, "adaptiveHeight": true }'>
                    <?php foreach ( $content_details as $content ) : ?>
                    <article>
                        <div class="wrapper">
                            <div class="featured-content-wrapper">
                                <div class="featured-image">
                                    <a href="<?php echo esc_url( $content['url'] ); ?>"><img src="<?php echo esc_url($content['image']); ?>" alt="<?php echo esc_attr( $content['title'] ); ?>"></a>
                                </div><!-- .featured-image -->
                                
                                <div class="entry-container">
                                    <header class="entry-header">
                                        <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                                    </header>

                                    <div class="entry-content">
                                        <p><?php echo wp_kses_post($content['excerpt']); ?></p>
                                    </div><!-- .entry-content -->

                                    <?php if(!empty($options['slider_btn_txt']) && !empty($options['slider_btn_alt_txt'])): ?>
                                        <div class="read-more">
                                            <a href="<?php echo esc_url($content['url']); ?>" class="btn"><?php echo esc_html($options['slider_btn_txt']); ?></a>
                                            <a href="<?php echo esc_url($slider_btn_alt_url); ?>" class="btn"><?php echo esc_html($options['slider_btn_alt_txt']); ?></a>
                                        </div><!-- .read-more -->
                                    <?php endif; ?>
                                </div><!-- .entry-container -->
                            </div><!-- .featured-content-wrapper -->
                        </div><!-- .wrapper -->
                    </article>
                    <?php endforeach; ?>
                </div><!-- .featured-slider -->

                <div class="slider-wave">
                    <img src="<?php echo esc_url( get_template_directory_uri().'/assets/uploads/01.png' ); ?>" alt="wave">
                </div><!-- .slider-wave -->
            </div><!-- #featured-slider-section -->
        </div>
           

    <?php
    }    
endif;

