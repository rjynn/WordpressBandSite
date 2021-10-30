<?php
/**
 * Testimonial section
 *
 * This is the template for the content of Testimonial section
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */

if ( ! function_exists( 'corpo_digital_add_testimonial_section' ) ) :
    /**
    * Add testimonial section
    *
    *@since  Corpo Digital 1.0.0
    */
    function corpo_digital_add_testimonial_section() {
    	$options = corpo_digital_get_theme_options();
        // Check if testimonial is enabled on frontpage
        $testimonial_enable = apply_filters( 'corpo_digital_section_status', true, 'testimonial_section_enable' );

        if ( true !== $testimonial_enable ) {
            return false;
        }
        // Get testimonial section details
        $section_details = array();
        $section_details = apply_filters( 'corpo_digital_filter_testimonial_section_details', $section_details );
        if ( empty( $section_details ) ) {
            return ;
        }

        // Render testimonial section now.
        corpo_digital_render_testimonial_section( $section_details );
    }
endif;

if ( ! function_exists( 'corpo_digital_get_testimonial_section_details' ) ) :
    /**
    * testimonial section details.
    *
    * @since  Corpo Digital 1.0.0
    * @param array $input testimonial section details.
    */
    function corpo_digital_get_testimonial_section_details( $input ) {
        $options = corpo_digital_get_theme_options();

        // Content type.
        $testimonial_count          = isset($options['testimonial_posts_count'] ) ? $options['testimonial_posts_count'] : 2;

        $content = array();
        $page_ids = array();

        for ( $i = 1; $i <= $testimonial_count; $i++ ) {
            if ( ! empty( $options['testimonial_content_page_' . $i] ) )
                $page_ids[] = $options['testimonial_content_page_' . $i];
        }

        $args = array(
            'post_type'         => 'page',
            'post__in'          => ( array ) $page_ids,
            'posts_per_page'    => absint( $testimonial_count ),
            'orderby'           => 'post__in',
            );

        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) :
            $i = 1;
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['content']        = corpo_digital_trim_content(25);
                $page_post['title']          = get_the_title();
                $page_post['url']            = get_the_permalink();
                $page_post['image']          = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'thumbnail' ) : get_template_directory_uri() . '/assets/uploads/no-featured-image-600x450.jpg';
                $page_post['designation']    = isset($options['testimonial_post_designation_'.$i])?$options['testimonial_post_designation_'.$i] : '';
                // Push to the main array.
                array_push( $content, $page_post );
                $i++;
            endwhile;
        endif;
        wp_reset_postdata();

        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// testimonial section content details.
add_filter( 'corpo_digital_filter_testimonial_section_details', 'corpo_digital_get_testimonial_section_details' );


if ( ! function_exists( 'corpo_digital_render_testimonial_section' ) ) :
  /**
   * Start testimonial section
   *
   * @return string testimonial content
   * @since  Corpo Digital 1.0.0
   *
   */
   function corpo_digital_render_testimonial_section( $content_details = array() ) {
    $options            = corpo_digital_get_theme_options();

    if ( empty( $content_details ) ) {
        return;
    } ?>
    <div id="corpo_digital_testimonial_section" class="relative page-section" style="padding-top: 0;">
         <div id="testimonial-section" >
            <div class="wrapper">
                <div class="section-header">
                    <p class="section-subtitle"><?php echo esc_html($options['testimonial_section_sub_title']); ?></p>
                    <h2 class="section-title"><?php echo esc_html($options['testimonial_section_title']); ?></h2>
                </div><!-- .section-header -->

                <div class="testimonial-slider" data-slick='{"slidesToShow": 3, "slidesToScroll": 1, "infinite": true, "speed": 1000, "dots": true, "arrows":false, "autoplay": false, "draggable": true, "fade": false }'>
                <?php foreach($content_details as $content): ?>
                    
                    <article>
                        <div class="testimonial-item">
                            <div class="featured-image">
                                <a href="<?php echo esc_url($content['url']); ?>"><img src="<?php echo esc_url($content['image']); ?>" alt="<?php echo esc_attr($content['title']); ?>"></a>
                            </div><!-- .featured-image -->

                            <div class="entry-container">
                                <header class="entry-header">
                                    <h2 class="entry-title"><a href="<?php echo esc_url($content['url']); ?>"><?php echo esc_html($content['title']); ?></a></h2>
                                    <span class="designation"><?php echo esc_html($content['designation']); ?></span>
                                </header>

                                <div class="entry-content">
                                    <p><?php echo wp_kses_post($content['content']); ?></p>
                                </div><!-- .entry-content -->
                            </div><!-- .entry-container -->
                        </div><!-- .testimonial-item -->
                    </article>
                    <?php endforeach; ?>

                </div><!-- .section-content -->
            </div><!-- .wrapper -->
        </div><!-- #testimonial-section -->
    </div>

       
    <?php
    }
endif; ?>
