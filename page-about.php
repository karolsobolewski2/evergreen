<?php
/**
 * Template Name: about
 * Description: about template.
 */

get_header();
?>

<main class="main">
    <div class="container">
        <div class="about-wrapper">
            <?php while (have_posts()) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <?php the_content(); ?>

                </article>

            <?php endwhile; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
