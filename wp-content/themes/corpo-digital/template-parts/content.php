<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Theme Palace
 * @subpackage  Corpo Digital
 * @since  Corpo Digital 1.0.0
 */

$options = corpo_digital_get_theme_options();
$readmore = ! empty( $options['read_more_text'] ) ? $options['read_more_text'] : '';
?>
<article id="post-<?php the_ID(); ?>">
    <div class="post-wrapper">
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="featured-image">
                <a href="<?php the_permalink(); ?>"><img src="<?php the_post_thumbnail_url( 'post-thumbnail' ) ?>" alt="<?php the_title_attribute(); ?>"></a>
            </div><!-- .featured-image -->
        <?php endif; ?>

       <div class="entry-container">
            <header class="entry-header">
                <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            </header>

            <div class="entry-content">
                <?php the_excerpt(); ?>
                <?php if(!empty($readmore)) :?>
                    <a href="<?php the_permalink(); ?>" class="btn" ><?php echo esc_html( $readmore ); ?></a>
                <?php endif; ?>
            </div>
        </div><!-- .entry-container -->
    </div>
</article>
