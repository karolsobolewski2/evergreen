<?php
/**
 * Template Name: blog
 * Description: blog template.
 */
get_header();
?>

<div class="container">

<?php
$query = new WP_Query(array(
    'post_type' => 'post',
    'posts_per_page' => 10,
    'paged' => (get_query_var('paged')) ? get_query_var('paged') : 1
    ));

if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
            <?php the_excerpt(); ?>
            <?php the_tags(); ?>

        </article>
    <?php endwhile; ?>

    <article class="posts-nav">
        <div class="posts-nav__prev">
            <?php previous_posts_link('« ' . __('Poprzednia strona', NS)); ?>
        </div>
        <div class="posts-nav__next">
            <?php next_posts_link(__('Następna strona', NS) . ' »', $query->max_num_pages); ?>
        </div>
    </article>
<?php endif; ?>

</div>

<?php get_footer(); ?>
