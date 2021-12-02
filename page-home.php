<?php
/**
 * Template Name: Home
 * Description: Home page template.
 */

?>

<?php get_header(); ?>


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
            <button type="submit" class="before-search-sidebar"></button>
</form>
<div class="product-categories__wrapper">

<?php

$parent_cat_arg = array('hide_empty' => false, 'parent' => 0,  'order'    => 'ASC',
'orderby'  => '', 'exclude' => '1,454' ,
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
                        <a href="<?php echo get_permalink(67180)?>category/<?php echo $catVal->slug.'/'.$child_term->slug.'/subcategory/'.$child_terms->slug  ?>">
                            <?php echo $child_terms->name; ?>
                        </a>
                    </li>
            <?php }; ?>
         </ul>
         <?php
       }
    echo '</ul></li>';
        }
        ?>
    </div>
    </div>
    <div class="main-content">
        <?php
            $default_category = null;
            $category = get_category(get_query_var('cat'));
            $search = get_search_query();
            // search always everywhere
            if ($search == '') {
                $params['cat'] = $default_category;
                $params['category_name'] = $category_name;
            }
            $query = new WP_Query($params);
        ?>
        <div class="category-title">
            <span class="all-categories">
                <a>NASZA OFERTA</a>
            </span>
        </div>

        <?php if( have_rows('info_repeater') ): ?>
        <?php while( have_rows('info_repeater') ) : the_row(); 

            $infoTitleSection = get_sub_field('info_title_section');
            $infoTextSection = get_sub_field('info_text_section');
            $infoPhotoSection = get_sub_field('info_photo_section');
            $size = 'full';
        ?>    
       <?php endwhile; ?>
        <?php else : ?>
        <?php endif; ?>
       
        <?php if ($query->have_posts()) :
            $i = 0;
            $j= 0;
            foreach ($parent_cat as $catVal) {
            $i++;
            $j++;
            if($i % 4 == 0){
            
        ?>
            <div class="centerContent product-center">
                <div class="offer-photo"></div>
                <div class="rectangle-promo"><p>POLECANE</p></div>
                <div class="text-cat">
                    <h2 class="title-center"><?php echo $infoTitleSection; ?></h2>
                    <p class="first-text"> <?php echo $infoTextSection; ?></p>
                </div>
                <div class="single-product">
               
                <img class="book" src="<?php echo $infoPhotoSection ?>">
                
                </div>
            </div>
        
            <?php }
                ?>
                
            <div class="centerContent">
                <div class="photo-cat">
                    <h2 class="title-cat">
                    <a "<?php echo $catVal->slug ?>"><?php echo $catVal->name ?></a>
					<span class="category-name">
								<a href=<?php echo get_category_link(get_the_category($term_id)); ?>></a>
                        </span>
					 </h2>
                    <img class="sweet" src="<?php echo z_taxonomy_image_url($catVal->term_id, NULL, TRUE); ?>"/>
                    <div class="offer-photo"></div>
                </div>
                <div class="category-banner">
                    <div class="cat-child">
                        <?php
                        $child_arg = array( 'hide_empty' => false, 'parent' => $catVal->term_id );
                        $child_cat = get_terms( 'category', $child_arg );
                        $k = 0;
                        ?>
                        <ul class="tabs-nav">
                            <?php foreach( $child_cat as $child_term ) { 
                                $k ++;
                            ?>
                                <li data-tab="<?php echo $j.".".$k ?>" class="child-main-content tab-nav-ofert"  ><a href=" <?php get_permalink() ?> category/<?php echo $catVal->slug.'/'.$child_term->slug  ?>"><?php echo $child_term->name  ?></a> </li>
                            <?php
                            } ?>
                        </ul>
                    </div>
                </div>
                <?php
                $k= 0;
                foreach( $child_cat as $child_term ) { 
                $k++;
                ?>

                <?php $query = new WP_Query( array(
                        'post_type' => 'product',
                        'posts_per_page' => 1,
                        'orderby' => 'rand',
                        'meta_query' => array(
                            array(
                              'key' => 'recommended_product',
                              'value' => '1',
                            )
                        ),
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'category',
                                'field' => 'slug',
                                'terms' => $child_term->slug,
                            )
                        )
                    ));
                ?>
                <div id="tab-product-box-<?php echo $j.".".$k?>" class=" tab-content-ofert-box">
                <?php  while ($query->have_posts()) : $query->the_post(); 
                    $id_product = get_the_id();
                    $fields = get_fields(); 
                    $product_image = wp_get_attachment_image_src(get_post_thumbnail_id($id_product), 'regular');
                    if($fields['recommended_product']) { ?>
                        <div  class="single-right" >
                            <div class="rectangle"><p>POLECANE</p></div>
                            <a href="<?php echo get_permalink() ?>" >
                                <img class="pendrive" src="<?php echo $product_image[0]; ?>" />
                            </a>
                            <p><?php the_title(); ?></p>
                            <a href="<?php echo get_permalink(67180)."category/".$catVal->slug."/".$child_term->slug ?>"><button class="show-all-btn">Pokaż wszystkie</button></a>
                        </div>
                    <?php }
                endwhile;?>
                </div>

                <?php
                } 
                 ?>


            </div>
            <!--   category on mobile      -->
            <div class="category-banner mobile">
                    <div class="cat-child">
                    <?php
                        $child_arg = array( 'hide_empty' => false, 'parent' => $catVal->term_id );
                        $child_cat = get_terms( 'category', $child_arg );
                        $k = 0;
                        ?>
                        <ul class="tabs-nav">
                            <?php foreach( $child_cat as $child_term ) { 
                                $k ++;
                            ?>
                                <li  class="child-main-content tab-nav-ofert"><a href=" <?php get_permalink() ?> category/<?php echo $catVal->slug.'/'.$child_term->slug  ?>"><?php echo $child_term->name  ?></a> </li>
                            <?php
                            } ?>
                        </ul>
                    </div>
                    </div>
            <div class="single-mobile-wrapper">
                <?php $query = new WP_Query( array(
                        'post_type' => 'product',
                        'posts_per_page' => 1,
                        'orderby' => 'rand',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'category',
                                'field' => 'slug',
                                'terms' => $catVal->slug,
                            )
                        )
                    ));
                ?>
                <?php  while ($query->have_posts()) : $query->the_post(); ?>
                    <div>
                        <?php $id_product = get_the_id();
                        $product_image = wp_get_attachment_image_src(get_post_thumbnail_id($id_product), 'regular'); ?>
                        <div  class="single-mobile-product" >
                            <div class="rectangle"><p>POLECANE</p></div>
                            <a href="<?php echo get_permalink() ?>" >
                                <img class="pendrive" src="<?php echo $product_image[0]; ?>" />
                            </a>
                            <p><?php the_title(); ?></p>
                            <a href="<?php echo get_permalink(67180)."category/".$catVal->slug."/".$child_term->slug ?>"><button class="show-all-btn">Pokaż wszystkie</button></a>
                        </div>
                    </div>
                <?php
                endwhile;?>
            </div>
        <?php
        }?>
        <?php endif; ?>
    </div>
</div>





<?php get_footer(); ?>
