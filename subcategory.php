<div class="background-popup" >

<?php
/**
 * Template Name: Category
 * Description: Subcategory page template.
 */

?>



<?php

/**
 * A file to display subcategory
 */

get_header(); ?>

                <?php
                        $term = get_queried_object();
                        $idObj = get_category_by_slug( $term->slug );
                        $photo_banner = get_field('photo_banner', $term);
                ?>


<?php if( get_field('photo_banner') ) { ?> 


    <div id="banner"> 
<img class="banner-photo" src="<?php echo esc_url($photo_banner['url']); ?>" >
    </div>
<?php } ?>




</div>



<div class="main-wrapper" >


<div id="sitebar" class="text-center">

<form class="search-form" id="search-form" method="GET">
            <?php $search_placeholder = $is_locale_en ? "Search" : "Wyszukiwarka"; ?>
            <input class="input-text" name='s' value="<?php echo get_search_query(); ?>" placeholder="<?php echo $search_placeholder; ?>" />
            <button type="submit" class="before-search-sidebar"></button>
</form>
<div class="product-categories__wrapper">
<?php

$parent_cat_arg = array('hide_empty' => false, 'parent' => 0,  'order'    => 'ASC',
'orderby'  => '', 'exclude' => '1,454',
'hierarchical' => 1, );
$parent_cat = get_terms('category',$parent_cat_arg);//category name
$a = 0;
foreach ($parent_cat as $catVal) {
    $a++;
    ?>
    <h3 class="product-categories categories" data-tab='<?php echo $a ?>'><a><?php echo $catVal->name ?></a></h3>
    <?php 
        $child_arg = array( 'hide_empty' => false, 'parent' => $catVal->term_id );
        $child_cat = get_terms( 'category', $child_arg );
        echo '<ul id="tab-'.$a.'" class="open">';
        $i = 0;
        foreach( $child_cat as $child_term ) { $i++;?>

         <li class="child-category"><a href=" <?php echo get_permalink(67180)?>category/<?php echo $catVal->slug.'/'.$child_term->slug  ?>"><?php echo $child_term->name  ?></a> </li>
         <ul class="child-subCategory">
            <?php
                $child_args = array( 'hide_empty' => false, 'parent' => $child_term->term_id );
                $child_cats = get_terms( 'category', $child_args );
                // print_r($child_cats->name);
                foreach ($child_cats as $child_terms) { ?>
                    <li>
                        <a class="single-sub-name"  href="<?php echo get_permalink(67180)?>category/<?php echo $catVal->slug.'/'.$child_term->slug.'/subcategory/'.$child_terms->slug  ?>">
                       <span id="name"><?php echo $child_terms->name; ?></span>
                        </a>
                    </li>
            <?php }; ?>
         </ul>
         <?php
       }
    echo '</ul></li>';
}

            wp_reset_query();
            ?>
        </div>
        </div>



    <div class="main-content main-content-subcategory">

    <?php
        $term = get_queried_object();
        $idObj = get_category_by_slug( $term->slug );
        $id = $idObj->term_id;
        $ofertName = get_field('ofert_name', $term);
        $ofertDescript = get_field('ofert_description', $term);
        $ofertPhoto = get_field('photo_offer', $term);
        $get_parent_cats = array(
            'parent' => $id //get top level categories only
        );
        $all_categories = get_categories( $get_parent_cats ); 

       
    ?>
            
        <h1 id="subSubCategoryBreadcrumbs" class="category-name-sub sub-margin"><?php echo get_category_parents($term->term_id, true, ''); ?></h1>
        


        <div class="promo-section">

                <div class="img-photo-container">

                    <img class="photo-promo" src="<?php echo esc_url($ofertPhoto['url']); ?>" >
        
                </div>
                    <h2 class="promo-title">
                        <?php echo $ofertName; ?>
                    </h2>

                    <br>

                    <p class="promo-text">
                        <?php echo $ofertDescript; ?>
                    </p>
                </div>



        <?php
        $j = 0;
        foreach( $all_categories as $single_category ){
        $j++;
            $catID = $single_category->cat_ID;?>
             <div class="subcategory-all-products-btn">
                <h3 class="subcategory-name"><?php echo $single_category->name ?></h3>
                <div class="btn-wrapper-subcategory">
                <a class="all-products" href="subcategory/<?php echo $single_category->category_nicename?>">Zobacz wszystkie</a>
                </div>
            </div>
            <div class="div-product-subcategory">
                <?php $query = new WP_Query( array(
                        'post_type' => 'product',
                        'posts_per_page' => 3,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'category',
                                'field' => 'slug',
                                'terms' => $single_category->slug,
                            )
                        )
                    ));
                ?>
                <?php 
                $k = 0;
                while ($query->have_posts()) : $query->the_post(); 
                $k++;
                ?>
                
                    <div class="single-product-subcategory">
                    <a class="single-prevent-wrapper" href="<?php echo get_permalink() ?>">
                        <div class="product-photo-container">
                            <a href="<?php echo get_permalink() ?>">
                            <img class="single-product-subcategory-img" src="<?php  echo get_the_post_thumbnail_url(); ?>" />  
                            </a>
                        </div>
                        <div class="product-name-subcategory">
                            <p class="single-sub-name-rec"><a href="<?php echo get_permalink() ?>"><?php echo the_title(); ?></a></p>
                        </div>
                        <div class="add-to-cart-sub">
                            <button class="sub-cart-product cart-popup" data-tab="<?php echo $j.$k ?>">
                                <a>+ dodaj do wyceny</a>
                            </button>
                        </div>
                    </a>    
                    </div>
                    <?php include 'popup.php'; ?>
                <?php endwhile; ?>
            </div>
            <div class="subcategory-all-products-btn mobile-all-products">
                <a class="all-products" href="subcategory/<?php echo $single_category->category_nicename?>">Zobacz wszystkie</a>
            </div>
        <?php } ?>
</div>
                <script>
                var currentProductObject = <?php echo json_encode(array(
                    'id' => get_the_ID(),
                    'image' => array_shift($imageUrls),
                    'price' => (float)IDGTools::getPriceDiscounted($productPrice),
                    'priceFormatted' => IDGTools::getPriceDiscountedFormatted($productPrice),
                    'isDiscount' => IDGTools::isDiscount(),
                    'priceRegular' => (float)IDGTools::getPriceRegular($productPrice),
                    'priceRegularFormatted' => IDGTools::getPriceRegularFormatted($productPrice),
                    'name' => $productName,
                )); ?>;
                </script>

</div>
<?php get_footer(); ?>
