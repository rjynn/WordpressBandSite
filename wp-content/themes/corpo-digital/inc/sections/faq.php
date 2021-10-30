<?php
/**
 * faq section
 *
 * This is the template for the content of faq section
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */
if ( ! function_exists( 'corpo_digital_add_faq_section' ) ) :
    /**
    * Add faq section
    *
    *@since  Corpo Digital 1.0.0
    */
    function corpo_digital_add_faq_section() {
    	$options = corpo_digital_get_theme_options();
        // Check if faq is enabled on frontpage
        $faq_enable = apply_filters( 'corpo_digital_section_status', true, 'faq_section_enable' );

        if ( true !== $faq_enable ) {
            return false;
        }
        // Get faq section details
        $section_details = array();
        $section_details = apply_filters( 'corpo_digital_filter_faq_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render faq section now.
        corpo_digital_render_faq_section( $section_details );
    }
endif;

if ( ! function_exists( 'corpo_digital_get_faq_section_details' ) ) :
    /**
    * faq section details.
    *
    * @since  Corpo Digital 1.0.0
    * @param array $input faq section details.
    */
    function corpo_digital_get_faq_section_details( $input ) {
        $options = corpo_digital_get_theme_options();

        // Content type.
        
        $faq_count =  3;

        $content = array();
       
        $page_ids = array();

        for ( $i = 1; $i <= absint($faq_count); $i++ ) {
            if ( ! empty( $options['faq_content_page_' . $i] ) ) :
                $page_ids[] = $options['faq_content_page_' . $i];
            endif;
        }
        
        $args = array(
            'post_type'         => 'page',
            'post__in'          => ( array ) $page_ids,
            'posts_per_page'    => absint($faq_count),
            'orderby'           => 'post__in',
            );                    

        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['excerpt']   = has_excerpt() ? get_the_excerpt() : corpo_digital_trim_content(15);

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
// faq section content details.
add_filter( 'corpo_digital_filter_faq_section_details', 'corpo_digital_get_faq_section_details' );


if ( ! function_exists( 'corpo_digital_render_faq_section' ) ) :
  /**
   * Start faq section
   *
   * @return string faq content
   * @since  Corpo Digital 1.0.0
   *
   */
   function corpo_digital_render_faq_section( $content_details = array() ) {
        $options = corpo_digital_get_theme_options();
        $class = (!empty($options['faq_image'])) ? 'has-post-thumbnail' : 'no-post-thumbnail';

        if ( empty( $content_details ) ) {
            return;
        } ?>
        <div id="corpo_digital_faq_section" class="relative page-section">
            <div id="faq-section">
                <div class="wrapper">
                    <article class="<?php echo $class; ?>">

                        <?php if(!empty($options['faq_image'])): ?>
                            <div class="featured-image">
                                <a href="#"><img src="<?php echo esc_url($options['faq_image']); ?>" alt="FAQ"></a>
                            </div><!-- .featured-image -->
                        <?php endif; ?>

                        <div class="entry-container">
                            <div class="section-header">
                                <p class="section-subtitle"><?php echo esc_html( $options['faq_sub_title'] ); ?></p>
                                <h2 class="section-title"><?php echo esc_html( $options['faq_title'] ); ?></h2>
                            </div><!-- .section-header -->

                            <div class="faq-group">

                                <?php foreach($content_details as $key => $content): ?>
                                    <div class="each-faq <?php if($key==0) echo 'open'; ?>">
                                        <a href="<?php echo esc_url($content['url']); ?>" class="faq-trigger"><?php echo esc_html( $content['title'] ); ?><i class="fa fa-angle-down"></i></a>

                                        <div class="faq-content">
                                            <p><?php echo wp_kses_post($content['excerpt']); ?></p>
                                        </div> <!-- .faq-content -->
                                    </div><!-- .each-faq -->
                                <?php endforeach; ?>

                            </div><!-- .faq-group -->
                        </div><!-- .entry-container -->
                    </article>
                </div><!-- .wrapper -->
            </div><!-- #faq-section -->
        </div>
        

<?php }
endif;