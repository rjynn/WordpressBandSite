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
if ( ! function_exists( 'corpo_music_add_team_section' ) ) :
    /**
    * Add team section
    *
    *@since  Corpo Digital Pro 1.0.0
    */
    function corpo_music_add_team_section() {

        // Check if team is enabled on frontpage
        $team_enable = get_theme_mod('corpo_music_playlist_section_enable', false );

        if ( true !== $team_enable ) {
            return false;
        }
        // Get team section details
        $section_details = array();
        $section_details = apply_filters( 'corpo_music_filter_team_section_details', $section_details );

        if ( empty( $section_details ) ) {
            return;
        }

        // Render team section now.
        corpo_music_render_team_section( $section_details );
    }
endif;

if ( ! function_exists( 'corpo_music_get_team_section_details' ) ) :
    /**
    * team section details.
    *
    * @since  Corpo Digital Pro 1.0.0
    * @param array $input team section details.
    */
    function corpo_music_get_team_section_details( $input ) {
        
        $team_count = 3;
        $content = array();
        $page_ids = array();
        $position = array();

        for ( $i = 1; $i <= absint($team_count); $i++ ) {
            if ( ! empty(  get_theme_mod('corpo_music_team_content_page_'.$i, '' ) ) ) :
                $page_ids[] =  get_theme_mod('corpo_music_team_content_page_'.$i, '' );
            endif;
        }
        
        $args = array(
            'post_type'         => 'page',
            'post__in'          => ( array ) $page_ids,
            'posts_per_page'    => absint($team_count),
            'orderby'           => 'post__in',
        );                    
           
        $query = new WP_Query( $args );
        $i = 1;
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['title']     = get_the_title();
                $page_post['position']  = (! empty(  get_theme_mod('corpo_music_team_position_'.$i, '' ) ) ) ?  get_theme_mod('corpo_music_team_position_'.$i, '' ) : '';
                $page_post['social']    = (! empty( get_theme_mod('corpo_music_team_social_'.$i, '' ) ) ) ? get_theme_mod('corpo_music_team_social_'.$i, '' ) : '';
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
add_filter( 'corpo_music_filter_team_section_details', 'corpo_music_get_team_section_details' );


if ( ! function_exists( 'corpo_music_render_team_section' ) ) :
  /**
   * Start team section
   *
   * @return string team content
   * @since  Corpo Digital Pro 1.0.0
   *
   */
   function corpo_music_render_team_section( $content_details = array() ) {

        if ( empty( $content_details ) ) {
            return;
        } ?>

        <div id="corpo_digital_team_section" class="relative page-section">
            <div id="team-section">
                <div class="wrapper">
                    <div class="section-header">
                        <?php if ( !empty( get_theme_mod('corpo_music_team_sub_title', '' ) ) ): ?>
                            <p class="section-subtitle"><?php echo esc_html( get_theme_mod('corpo_music_team_sub_title', '' ) ); ?></p>
                        <?php endif ?>
                        <?php if ( !empty( get_theme_mod('corpo_music_team_title', '' ) ) ): ?>
                            <h2 class="section-title"><?php echo esc_html( get_theme_mod('corpo_music_team_title', '' ) ); ?></h2>
                        <?php endif ?>       
                    </div><!-- .section-header -->

                    <div class="section-content col-3 clear">
                        <?php foreach ( $content_details as $content ) : ?>

                        <article>
                            <div class="team-item-wrapper">
                                <div class="featured-image">
                                    <a href="<?php echo esc_url($content['url']); ?>"><img src="<?php echo esc_url($content['image']); ?>" alt="<?php echo esc_attr($content['title']); ?>"></a>
                                </div><!-- .featured-image -->

                                <div class="entry-container">
                                    <header class="entry-header">
                                        <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                                        <?php if(!empty($content['position'])) echo '<span class="team-position">'.esc_html( $content['position'] ).'</span>'; ?>
                                    </header>
                                    <?php
                                    if ( ! empty( $content['social'] ) ) : 
                                        $social = explode( '|', $content['social'] ); ?>
                                        <div class="social-icons">
                                            <ul>
                                                <?php foreach( $social as $social_link ) : ?>
                                                <li>
                                                    <a href="<?php echo esc_url( $social_link ); ?>">
                                                        <?php echo corpo_digital_return_social_icon( $social_link ); ?>
                                                    </a>
                                                </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>

                                </div><!-- .entry-container -->
                            </div><!-- team-item-wrapper -->
                        </article>
                        <?php endforeach; ?>

                    </div><!-- .col-3 -->
                </div><!-- .wrapper -->
            </div><!-- #team-section -->
        </div>
        

<?php }
endif;