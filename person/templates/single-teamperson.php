
<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Avior
 */
get_header(); ?>
<?php if ( have_posts() ) :
    while ( have_posts() ) :
        the_post(); ?>
            <div class="wrapper main-wrapper clear">
                <div id="primary" class="content-area ">
                    <main id="main" class="site-main" role="main">
                        <article id="post-<?php the_ID(); ?>">

                            <header class="entry-header">
                                <?php
                                if ( 'post' === get_post_type() ) {
                                        echo '<div class="entry-meta">';
                                    if ( is_single() ) {
                                        twentyseventeen_posted_on();
                                    } else {
                                        echo twentyseventeen_time_link();
                                        twentyseventeen_edit_link();
                                    };
                                    echo '</div><!-- .entry-meta -->';
                                };

                                if ( is_single() ) {
                                    the_title( '<h1 class="entry-title">', '</h1>' );
                                } elseif ( is_front_page() && is_home() ) {
                                    the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
                                } else {
                                    the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
                                }
                                ?>
                            </header><!-- .entry-header -->

                            <?php if ( '' !== get_the_post_thumbnail() && ! is_single() ) : ?>
                                <div class="post-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail( 'twentyseventeen-featured-image' ); ?>
                                    </a>
                                </div><!-- .post-thumbnail -->
                            <?php endif; ?>

                            <div class="entry-content">
                                <?php
                                the_content(
                                    sprintf(
                                    /* translators: %s: Post title. */
                                        __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'twentyseventeen' ),
                                        get_the_title()
                                    )
                                );

                                wp_link_pages(
                                    array(
                                        'before'      => '<div class="page-links">' . __( 'Pages:', 'twentyseventeen' ),
                                        'after'       => '</div>',
                                        'link_before' => '<span class="page-number">',
                                        'link_after'  => '</span>',
                                    )
                                );
                                ?>
                            </div><!-- .entry-content -->

                            <?php
                            if ( is_single() ) {
                                twentyseventeen_entry_footer();
                            }
                            ?>

                        </article><!-- #post-<?php the_ID(); ?> -->



                    // If comments are open or we have at least one comment, load up the comment template.
                        <?php  if ( comments_open() || get_comments_number() ) :
                                comments_template();
                            endif;
                        ?>
                </main><!-- #main -->
            </div><!-- #primary -->
                <?php get_sidebar(); ?>
        </div><!-- .wrapper -->
    <?php
    endwhile; // End of the loop.
else:?>
    <div class="wrapper main-wrapper clear">
        <div id="primary" class="content-area ">
            <main id="main" class="site-main" role="main">
                <?php get_template_part( 'template-parts/content', 'none' ); ?>
            </main><!-- #main -->
        </div><!-- #primary -->
        <?php get_sidebar(); ?>
    </div><!-- .wrapper -->
<?php endif;
get_footer();