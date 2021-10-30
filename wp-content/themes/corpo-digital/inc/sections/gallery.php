<?php
/**
 * Gallery section
 *
 * This is the template for the content of Gallery section
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */
if ( ! function_exists( 'corpo_digital_add_gallery_section' ) ) :
    /**
    * Add Gallery section
    *
    *@since  Corpo Digital 1.0.0
    */
    function corpo_digital_add_gallery_section() {
        $options = corpo_digital_get_theme_options();
        // Check if Gallery is enabled on frontpage
        $gallery_enable = apply_filters( 'corpo_digital_section_status', true, 'gallery_section_enable' );

        if ( true !== $gallery_enable ) {
            return false;
        }
        // Get Gallery section details
        $section_details = array();
        $section_details = apply_filters( 'corpo_digital_filter_gallery_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }
        // Render Gallery section now.
        corpo_digital_render_gallery_section( $section_details );
    }
endif;

if ( ! function_exists( 'corpo_digital_get_gallery_section_details' ) ) :
    /**
    * Gallery section details.
    *
    * @since  Corpo Digital 1.0.0
    * @param array $input Gallery section details.
    */
    function corpo_digital_get_gallery_section_details( $input ) {
        $options = corpo_digital_get_theme_options();

        // Content type.
        $gallery_count = ! empty( $options['gallery_count'] ) ? $options['gallery_count'] : 6;
        
        $content = array();

        $cat_ids = ! empty( $options['gallery_category_exclude'] ) ? $options['gallery_category_exclude'] : array();
        $args = array(
            'post_type'             => 'post',
            'posts_per_page'        => absint( $gallery_count ),
            'category__not_in'      => ( array ) $cat_ids,
            'ignore_sticky_posts'   => true,
            );                    

        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['id']        = get_the_id();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['image']     = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'post-thumbnail' ) : get_template_directory_uri() . '/assets/uploads/no-featured-image-600x450.jpg';
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
// gallery section content details.
add_filter( 'corpo_digital_filter_gallery_section_details', 'corpo_digital_get_gallery_section_details' );


if ( ! function_exists( 'corpo_digital_render_gallery_section' ) ) :
  /**
   * Start gallery section
   *
   * @return string gallery content
   * @since  Corpo Digital 1.0.0
   *
   */
   function corpo_digital_render_gallery_section( $content_details = array() ) {
        $options                = corpo_digital_get_theme_options();

        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="corpo_digital_gallery_section" class="relative page-section">
            <div id="gallery-section">
                <div class="wrapper">
                    <div class="section-header">
                        <p class="section-subtitle"><?php echo esc_html($options['gallery_section_sub_title'])?></p>
                        <h2 class="section-title"><?php echo esc_html($options['gallery_title'])?></h2>
                    </div><!-- .section-header -->

                    <div class="section-content col-3 clear">
                    <?php foreach($content_details as $content) : ?>

                        <article>
                            <div class="featured-image" style="background-image: url('<?php echo esc_url($content['image']); ?>');">
                                <header class="entry-header">
                                    <h2 class="entry-title"><a href="<?php echo esc_url($content['url']);?>" tabindex="0"><?php echo esc_html($content['title']) ?></a></h2>
                                </header>
                            </div><!-- .featured-image -->
                        </article>
                        <?php endforeach; ?>

                    </div><!-- .col-3 -->
                </div><!-- .wrapper -->
            </div><!-- #gallery-section -->
        </div>
        
    <?php }
endif;  ?>
