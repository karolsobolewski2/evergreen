<?php

get_header();

?>

<main class="main">
    <div class="container">

        <?php while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                <?php the_content(); ?>

            </article>

        <?php endwhile; ?>

    </div>
</main>

<?php get_footer(); ?>
