<!-- <?php
/**
 * Template Name: Category
 * Description: Category page template.
 */

?>



<?php

/**
 * A file to display category
 */

get_header(); ?>
<div class="slider" id="banner"> 
<?php
echo do_shortcode('[smartslider3 slider=3]');
?>
</div>

<div class="main-wrapper" >


<div id="sitebar" class="text-center">

<form class="search-form" id="search-form" method="GET">
            <?php $search_placeholder = $is_locale_en ? "Search" : "Wyszukiwarka"; ?>
            <input class="input-text" name='s' value="<?php echo get_search_query(); ?>" placeholder="<?php echo $search_placeholder; ?>" />
</form>

<?php

$parent_cat_arg = array('hide_empty' => false, 'parent' => 0,  'order'    => 'ASC',
'orderby'  => '', 'exclude' => '1,454',
'hierarchical' => 1, );
$parent_cat = get_terms('category',$parent_cat_arg);//category name
$a = 0;
foreach ($parent_cat as $catVal) {
    $a++;
    echo '<h3 class="product-categories categories" data-tab='.$a.'>'.'<a>'.$catVal->name.'</h3>'; //Parent Category
$args = array('post_type' => 'product',
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field' => 'slug',
                'terms' => $custom_term->slug,
            ),
        ),
     );

wp_reset_query();
    $child_arg = array( 'hide_empty' => false, 'parent' => $catVal->term_id );
    $child_cat = get_terms( 'category', $child_arg );
    echo '<ul id="tab-'.$a.'">';
        $i = 0;
        foreach( $child_cat as $child_term ) { 
            $i++;
         echo '<li class="child-category">'.'<a href="'. get_permalink(). '; ">'.$child_term->name . '</a></li>'; //Child Category
            
            $my_query = new WP_Query( $args );
if( $my_query->have_posts() ) {
    while ($my_query->have_posts()) : $my_query->the_post(); ?>
        <ul><li><a href="#" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a><li></ul><?php            
    endwhile;
}
wp_reset_query();
        }
    echo '</ul></li>';
    
}
?>



    </div>
    <div class="main-content">
    
    <h1 class="category-name">
    <?php echo $catVal->name ?>
    </h1>
    <?php the_content(); ?>
    </div>

 
<?php get_footer(); ?> -->
