<?php
/**
 * Banner section
 *
 * This is the template for the content of about section
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */
if ( ! function_exists( 'corpo_digital_add_about_section' ) ) :
    /**
    * Add about section
    *
    *@since  Corpo Digital 1.0.0
    */
    function corpo_digital_add_about_section() {
    	$options = corpo_digital_get_theme_options();
        // Check if about is enabled on frontpage
        $about_enable = apply_filters( 'corpo_digital_section_status', true, 'about_section_enable' );

        if ( true !== $about_enable ) {
            return false;
        }
        // Get about section details
        $section_details = array();
        $section_details = apply_filters( 'corpo_digital_filter_about_section_details', $section_details );
        if ( empty( $section_details ) ) {
            return ;
        }

        // Render about section now.
        corpo_digital_render_about_section( $section_details );
    }
endif;

if ( ! function_exists( 'corpo_digital_get_about_section_details' ) ) :
    /**
    * about section details.
    *
    * @since  Corpo Digital 1.0.0
    * @param array $input about section details.
    */
    function corpo_digital_get_about_section_details( $input ) {
        $options = corpo_digital_get_theme_options();

        // Content type.
        
        $content = array();
        $page_id = '';
        if ( ! empty( $options['about_content_page'] ) )
            $page_id = isset($options['about_content_page']) ? $options['about_content_page'] : '' ;

        $args = array(
            'post_type'             => 'page',
            'p'                     =>  absint( $page_id ),
            'ignore_sticky_posts'   => true,
            );


        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['id']        = get_the_id();
                $page_post['content']   = has_excerpt() ? get_the_excerpt() : corpo_digital_trim_content(30);
                $page_post['subtitle']  = !empty($options['about_section_title'])? $options['about_section_title']: esc_html__('Creative Vision','corpo-digital');
                $page_post['image']     = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'medium_large' ) : get_template_directory_uri() . '/assets/uploads/no-featured-image-600x450.jpg';
                $page_post['url']       = get_the_permalink( );
                $page_post['title']     = get_the_title();
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
// about section content details.
add_filter( 'corpo_digital_filter_about_section_details', 'corpo_digital_get_about_section_details' );


if ( ! function_exists( 'corpo_digital_render_about_section' ) ) :
  /**
   * Start about section
   *
   * @return string about content
   * @since  Corpo Digital 1.0.0
   *
   */
   function corpo_digital_render_about_section( $content_details = array() ) {
        $options        = corpo_digital_get_theme_options();
        
        if ( empty( $content_details ) ) {
            return;
        } ?>

        <?php $content = $content_details[0]; ?>

            <div id="corpo_digital_about_section" class="relative page-section">
                <div id="about-section" >
                    <div class="wrapper">
                        <article class="<?php echo (!empty($content['image'])) ? 'has-post-thumbnail' : 'no-post-thumbnail' ?>">

                            <div class="featured-image">
                                <a href="<?php echo esc_url($content['url']); ?>"><img src="<?php echo esc_url($content['image']); ?>" alt="<?php echo esc_attr($content['title']); ?>"></a>
                            </div><!-- .featured-image -->

                            <div class="entry-container">
                                <div class="section-header">
                                    <p class="section-subtitle"><?php echo esc_html($content['subtitle']); ?></p>
                                    <h2 class="section-title"><?php echo esc_html($content['title']); ?></h2>
                                </div><!-- .section-header -->

                                <div class="entry-content">
                                    <p><?php echo wp_kses_post($content['content']); ?></p>
                                </div><!-- .entry-content -->


                                <?php if(!empty($options['about_btn_label']) ): ?>
                                    <div class="read-more">
                                        <a href="<?php echo esc_url($content['url']); ?>" class="btn"><?php echo esc_html($options['about_btn_label'])?></a>
                                    </div><!-- .read-more -->
                                <?php endif; ?>

                            </div><!-- .entry-container -->
                        </article>
                    </div><!-- .wrapper -->
                </div><!-- #about-section -->
            </div>
          
      
    <?php
    }    
endif; ?>
