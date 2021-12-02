<?php
/**
 * A file to display a single post
 *
 * Template Post Type: post
 */

get_header();

?>

<main class="main">
    <div class="container">

        <?php if (have_posts()) : ?>
            <?php while (have_posts()) :the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <?php
                        echo '<h1>';
                            the_title();
                        echo '</h1>';

                        the_content();

                        echo '<br>';
                        the_tags();
                    ?>
                </article>

            <?php endwhile; ?>
        <?php endif; ?>

    </div>

</main>

<?php get_footer(); ?>

