<?php
/**
 * Playlist section
 *
 * This is the template for the content of playlist section
 *
 * @package Theme Palace
 * @subpackage Dark Music Pro
 * @since Dark Music Pro 1.0.0
 */
if ( ! function_exists( 'corpo_music_add_playlist_section' ) ) :
    /**
    * Add playlist section
    *
    *@since Dark Music Pro 1.0.0
    */
    function corpo_music_add_playlist_section() {

        $playlist_enable = get_theme_mod('corpo_music_playlist_section_enable', false );

        if ( true !== $playlist_enable ) {
            return false;
        }

        // Render playlist section now.
        corpo_music_render_playlist_section();
    }
endif;

if ( ! function_exists( 'corpo_music_render_playlist_section' ) ) :
  /**
   * Start playlist section
   *
   * @return string playlist content
   * @since Dark Music Pro 1.0.0
   *
   */
   function corpo_music_render_playlist_section() {
        $playlist = ! empty( get_theme_mod('corpo_music_playlist_content', '' ) ) ? get_theme_mod('corpo_music_playlist_content', '' ) : array();
        $bg_image = !empty( get_theme_mod('corpo_music_playlist_bg_image', '' ) ) ? get_theme_mod('corpo_music_playlist_bg_image', '' ) : '';
        
        $args = array
            (
                'post_type' => 'attachment',
                'post_mime_type' => 'audio',
                'numberposts' => -1
            );
        $audiofiles = get_posts($args);
        for ($i=0; $i < count( $audiofiles ) ; $i++) { 
           $media_lists[$i] = $audiofiles[$i]->ID;
        }

        $media_lists = implode(',', $media_lists    );

        ?>
        <div id="music-player" class="relative">
            <div class="wrapper">
                <?php 
                    $playlist_shortcode = '[playlist type="audio" ids="' . $media_lists . '" style="light"]';
                    echo do_shortcode( wp_kses_post( $playlist_shortcode ) );  
                ?>
            </div><!-- .wrapper -->
        </div><!-- #playlist-section -->
        <div id="corpo_digital_playlist_section" >
            <div id="playlist-section" class="relative page-section" style="background-image: url('<?php echo esc_url( $bg_image ); ?>');" >
                <div class="overlay"></div>
                <div class="wrapper">
                   <div class="section-header">
                        <?php if ( !empty( get_theme_mod('corpo_music_playlist_subtitle', '' ) ) ): ?>
                            <p class="section-subtitle"><?php echo esc_html( get_theme_mod('corpo_music_playlist_subtitle', '' ) ); ?></p>
                        <?php endif ?>
                        <?php if ( !empty( get_theme_mod('corpo_music_playlist_title', '' ) ) ): ?>
                            <h2 class="section-title"><?php echo esc_html( get_theme_mod('corpo_music_playlist_title', '' ) ); ?></h2>
                        <?php endif ?>                    
                    </div><!-- .section-header -->

                    <?php if ( ! empty( $playlist ) ) :
                        $playlist = implode(',', $playlist); ?>

                        <div class="playlist">
                            <?php if ( !empty( get_theme_mod('corpo_music_playlist_image', '' ) ) ): ?>
                                <div class="featured-image">
                                    <img src="<?php echo esc_url( get_theme_mod('corpo_music_playlist_image', '' ) ); ?>" alt="13">                              
                                </div>
                            <?php endif ?>  
                            <div class="wp-playlist-tracks">                    
                                <?php 
                                    $playlist_shortcode = '[playlist type="audio" ids="' . $playlist . '" style="light"]';
                                    echo do_shortcode( wp_kses_post( $playlist_shortcode ) );  
                                ?>
                            </div><!-- .wp-playlist-tracks -->
                        </div><!-- .playlist -->
                    <?php endif; ?>
                </div><!-- .wrapper -->
            </div><!-- #playlist-section -->
        </div>
       
    <?php }
endif;