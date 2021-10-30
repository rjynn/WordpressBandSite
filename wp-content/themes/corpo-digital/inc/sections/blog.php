<?php
/**
 * Blog section
 *
 * This is the template for the content of blog section
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */
if ( ! function_exists( 'corpo_digital_add_blog_section' ) ) :
    /**
    * Add blog section
    *
    *@since  Corpo Digital 1.0.0
    */
    function corpo_digital_add_blog_section() {
        $options = corpo_digital_get_theme_options();
        // Check if blog is enabled on frontpage
        $blog_enable = apply_filters( 'corpo_digital_section_status', true, 'blog_section_enable' );

        if ( true !== $blog_enable ) {
            return false;
        }
        // Get blog section details
        $section_details = array();
        $section_details = apply_filters( 'corpo_digital_filter_blog_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }
        // Render blog section now.
        corpo_digital_render_blog_section( $section_details );
    }
endif;

if ( ! function_exists( 'corpo_digital_get_blog_section_details' ) ) :
    /**
    * blog section details.
    *
    * @since  Corpo Digital 1.0.0
    * @param array $input blog section details.
    */
    function corpo_digital_get_blog_section_details( $input ) {
        $options = corpo_digital_get_theme_options();

        // Content type.
        $blog_count = ! empty( $options['blog_count'] ) ? $options['blog_count'] : 3;
        
        
        $content = array();

        $cat_id = ! empty( $options['blog_content_category'] ) ? $options['blog_content_category'] : '';
        $args = array(
            'post_type'             => 'post',
            'posts_per_page'        => absint( $blog_count ),
            'cat'                   => absint( $cat_id ),
            'ignore_sticky_posts'   => true,
            );                    


        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['id']        = get_the_id();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['excerpt']   = corpo_digital_trim_content( 30);
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
// blog section content details.
add_filter( 'corpo_digital_filter_blog_section_details', 'corpo_digital_get_blog_section_details' );


if ( ! function_exists( 'corpo_digital_render_blog_section' ) ) :
  /**
   * Start blog section
   *
   * @return string blog content
   * @since  Corpo Digital 1.0.0
   *
   */
   function corpo_digital_render_blog_section( $content_details = array() ) {
        $options                = corpo_digital_get_theme_options();

        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="corpo_digital_blog_section" class="relative page-section">
            <div id="latest-posts-section">
                <div class="wrapper">
                    <div class="section-header">
                        <p class="section-subtitle"><?php echo esc_html($options['blog_sub_title'])?></p>
                        <h2 class="section-title"><?php echo esc_html($options['blog_title'])?></h2>
                    </div><!-- .section-header -->

                    <div class="archive-blog-wrapper col-3 clear">
                        <?php foreach ($content_details as $content):?>

                        <article>
                            <div class="post-wrapper">
                                <div class="featured-image">
                                    <a href="<?php echo esc_url($content['url']);?>"><img src="<?php echo esc_url($content['image']);?>" alt="<?php echo esc_attr($content['title']); ?>"></a>
                                </div><!-- .featured-image -->

                                <div class="entry-container">
                                    <header class="entry-header">
                                        <h2 class="entry-title"><a href="<?php echo esc_url($content['url']); ?>" tabindex="0"><?php echo esc_html($content['title']); ?></a></h2>
                                    </header>

                                    <div class="entry-content">
                                        <p><?php echo wp_kses_post($content['excerpt']);?></p>
                                    </div><!-- .entry-content -->
                                </div><!-- .entry-container -->
                            </div><!-- .post-wrapper -->
                        </article>
                        <?php endforeach; ?>

                    </div><!-- .section-content -->
                </div><!-- .wrapper -->
            </div><!-- #latest-posts-section -->

        </div>
       
<?php }
endif;  ?>