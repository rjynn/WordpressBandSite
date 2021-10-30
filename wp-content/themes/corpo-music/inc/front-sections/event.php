<?php
/**
 * Team section
 *
 * This is the template for the content of team section
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital Pro
 * @since  Corpo Digital Pro 1.0.0
 */
if ( ! function_exists( 'corpo_music_add_event_section' ) ) :
    /**
    * Add team section
    *
    *@since  Corpo Digital Pro 1.0.0
    */
    function corpo_music_add_event_section() {

        // Check if team is enabled on frontpage
        $event_enable = get_theme_mod('corpo_music_event_section_enable', false );

        if ( true !== $event_enable ) {
            return false;
        }
        // Get team section details
        $section_details = array();
        $section_details = apply_filters( 'corpo_music_filter_event_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render team section now.
        corpo_music_render_event_section( $section_details );
    }
endif;

if ( ! function_exists( 'corpo_music_get_event_section_details' ) ) :
    /**
    * team section details.
    *
    * @since  Corpo Digital Pro 1.0.0
    * @param array $input team section details.
    */
    function corpo_music_get_event_section_details( $input ) {
        
        $event_count = 5;
        $content = array();
        $page_ids = array();
        $position = array();

        for ( $i = 1; $i <= absint($event_count); $i++ ) {
            if ( ! empty(  get_theme_mod('corpo_music_event_content_page_'.$i, '' ) ) ) :
                $page_ids[] =  get_theme_mod('corpo_music_event_content_page_'.$i, '' );
            endif;
        }
        
        $args = array(
            'post_type'         => 'page',
            'post__in'          => ( array ) $page_ids,
            'posts_per_page'    => absint($event_count),
            'orderby'           => 'post__in',
        );                    
           
        $query = new WP_Query( $args );
        $i = 1;
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['title']     = get_the_title();
                $page_post['location']  = (! empty(  get_theme_mod('corpo_music_event_location_'.$i, '' ) ) ) ?  get_theme_mod('corpo_music_event_location_'.$i, '' ) : '';
                 $page_post['date']  = (! empty(  get_theme_mod('corpo_music_event_date_'.$i, '' ) ) ) ?  get_theme_mod('corpo_music_event_date_'.$i, '' ) : '';
                  $page_post['time']  = (! empty(  get_theme_mod('corpo_music_event_time_'.$i, '' ) ) ) ?  get_theme_mod('corpo_music_event_time_'.$i, '' ) : '';
                $page_post['url']       = get_the_permalink();
                $page_post['image']  	= has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'post-thumbnails' ) : get_template_directory_uri() . '/assets/uploads/no-featured-image-600x450.jpg';

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
// team section content details.
add_filter( 'corpo_music_filter_event_section_details', 'corpo_music_get_event_section_details' );


if ( ! function_exists( 'corpo_music_render_event_section' ) ) :
  /**
   * Start team section
   *
   * @return string team content
   * @since  Corpo Digital Pro 1.0.0
   *
   */
   function corpo_music_render_event_section( $content_details = array()     ) {

    ?>
    <div id="corpo_digital_event_section">
        <div id="events-section" class="relative page-section" style="background-image: url('<?php echo esc_url( get_theme_mod( 'corpo_music_event_bg_image', '' ) ); ?>');">
            <div class="overlay"></div>
            <div class="wrapper">
                <div class="section-header">
                     <?php if ( !empty( get_theme_mod('corpo_music_event_sub_title', '' ) ) ): ?>
                        <p class="section-subtitle"><?php echo esc_html( get_theme_mod('corpo_music_event_sub_title', '' ) ); ?></p>
                    <?php endif ?>
                    <?php if ( !empty( get_theme_mod('corpo_music_event_title', '' ) ) ): ?>
                        <h2 class="section-title"><?php echo esc_html( get_theme_mod('corpo_music_event_title', '' ) ); ?></h2>
                    <?php endif ?>       
                </div><!-- .section-header -->

                <div class="section-content">
                    <?php foreach ( $content_details as $content ) : ?>
                        <article>
                            <div class="event-item clear">                      

                                <header class="entry-header">
                                    <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                                    <p class="location"><span class="tp-event-location"><?php echo esc_html( $content['location'] ); ?></span></p>
                                </header>

                                 <span class="posted-on">
                                    <time class="entry-date published updated" datetime="2018-04-06T11:33:16+00:00">
                                        <span class="tp-event-date"><?php echo esc_html( $content['date'] ); ?></span>
                                    </time>
                                    <p class="tp-event-start-time" style="text-align: center;"><?php echo esc_html( $content['time'] ); ?></p>
                                </span><!-- .posted-on -->

                                <div class="buy-ticket">
                                    <a href="<?php echo esc_url( $content['url'] ); ?>" class="btn"><?php echo esc_html( get_theme_mod('corpo_music_event_btn_label', '' ) ); ?></a>
                                </div><!-- .buy-ticket -->
                            </div><!-- .event-item -->
                        </article>            
                    <?php endforeach; ?>
                                                    
                </div><!-- .section-content -->
            </div><!-- .wrapper -->
        </div><!-- #events-section -->

    </div>
   

<?php }
endif;