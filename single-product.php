<div class="product-background-popup">
<?php
/**
 * A file to display a single post
 *
 * Template Post Type: product
 */

get_header();

?>

<div id="product-page" class="main-wrapper single-product">
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
    <h3 class="product-categories categories" data-tab='<?php echo $a ?>'><a href="javascript:;""><?php echo $catVal->name ?></a></h3>
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

            wp_reset_query();
            ?>
        </div>
        </div>
    <div class="main-content product-content">


            <?php
            $term = get_queried_object();
            $idCategoryParent = get_the_category($id)[0]->cat_ID;
            $productMainCategory = get_category($idCategoryParent);
            $productLastCategory = $productMainCategory->name
            ?>
            <p id="subSubCategoryBreadcrumbs" class="category-name-list list-product"><?php echo get_category_parents($idCategoryParent, true, ''); ?></p>

        <?php if (have_posts()) : ?>
            <?php while (have_posts()) :the_post(); ?>

                <article id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <?php /*
                    <div class="img-slider">
                        <?php $imageUrls = array(); ?>
                        <?php if (has_post_thumbnail()) : $imageUrls;?>
                            <div class="product-image">
                                <img  src="<?php echo get_the_post_thumbnail_url(); ?>"/>
                                <?php
                                $imageUrls = array(get_the_post_thumbnail_url(),);
                                ?>

                            </div>
                        <?php endif; ?>

                        <?php
                            $gal_images = get_field('images');
                            if ($gal_images): ?>
                                <?php foreach($gal_images as $gal_image): $imageUrls[] = esc_url($gal_image['sizes']['thumbnail']); ?>
                                    <div class="product-image">
                                        <img src="<?php echo esc_url($gal_image['sizes']['large']); ?>" alt="<?php echo esc_attr($gal_image['alt']); ?>" />
                                    </div>
                                <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    */?>
                    <div class="slider-nav">
                        <?php if (has_post_thumbnail()) :?>
                            <div class="product-image">
                                <img  src="<?php echo get_the_post_thumbnail_url(); ?>"/>
                            </div>
                        <?php endif; ?>

                        <?php
                            $gal_images = get_field('images');
                            if ($gal_images): ?>
                                <?php foreach($gal_images as $gal_image): ?>
                                    <div class="product-image">
                                        <img src="<?php echo esc_url($gal_image['sizes']['large']); ?>" alt="<?php echo esc_attr($gal_image['alt']); ?>" />
                                    </div>
                                <?php endforeach; ?>
                        <?php endif;
                            $img_urls = explode(',', get_field('img_url'));
                            if ($img_urls):
                                foreach($img_urls as $img_url): ?>
                                    <div class="product-image">
                                        <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($img_url); ?>" />
                                    </div>
                                <?php endforeach;
                            endif; ?>
                    </div>
                    <div class="product-name">
                            <div>
                                <span class="js-product-name-form-handler">
                                    <?php $productName = get_the_title(); echo $productName; ?>
                                </span>
                            </div>

                    <p class="number version-color">Wersje / Kolor</p>

                    <div class="slider-for">
                        <?php if (has_post_thumbnail()) :?>
                            <div class="slider-for-div" style="width: 100px;">
                                <img class="slider-for-img"  src="<?php echo get_the_post_thumbnail_url(); ?>"/>
                            </div>
                        <?php endif; ?>

                        <?php
                            $images = array();
                            $i = 0;

                            $gal_images = get_field('images');
                            foreach($gal_images as $gal_image) {
                                $images[$i] = $gal_image['sizes']['medium'];
                                $i++;
                            }

                            $img_urls = explode(',', get_field('img_url'));
                            foreach ($img_urls as $img_url) {
                                $images[$i] = $img_url;
                                $i++;
                            }

                            foreach($images as $image): ?>
                                <div class="slider-for-div" style="width: 100px;">
                                    <img class="slider-for-img" src="<?php echo esc_url($image); ?>" alt="<?php echo $image ?>" />
                                </div>
                        <?php endforeach; ?>
                    </div>

                    <?php /*
                    <div class="product-photos-small">
                        <?php $imageUrls = array(); ?>

                        <?php if (has_post_thumbnail()) : $imageUrls;?>
                                <img id="product-photo-popup" class="photo-single-product-small" src="<?php echo get_the_post_thumbnail_url(); ?>"/>
                                <?php
                                $imageUrls = array(get_the_post_thumbnail_url(),);
                                ?>
                        <?php endif; ?>
                        <?php
                            $gal_images = get_field('images');
                            if ($gal_images): ?>
                                <?php foreach($gal_images as $gal_image): $imageUrls[] = esc_url($gal_image['sizes']['thumbnail']); ?>
                                        <img id="product-photo-popup" class="photo-single-product-small" src="<?php echo esc_url($gal_image['sizes']['medium']); ?>" alt="<?php echo esc_attr($gal_image['alt']); ?>" />
                                <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    */?>

                    <!-- Zdjęcie do popupa  -->
                    <span class="popup-image-closer" onclick="PopupCloser()"></span>
                    <div class="popup-slider">
                        <?php
                            $gal_images = get_field('images');
                            if ($gal_images): ?>
                                    <div class="photo-single-popup">
                                        <img src="<?php echo $basketImg; ?>" />
                                    </div>
                                <?php foreach($gal_images as $gal_image): ?>
                                    <div class="photo-single-popup">
                                        <img src="<?php echo esc_url($gal_image['sizes']['large']); ?>" alt="<?php echo esc_attr($gal_image['alt']); ?>" />
                                    </div>
                                <?php endforeach;
                            endif;
                            if ($img_urls):
                                foreach($gal_images as $gal_image): ?>
                                    <div class="photo-single-popup">
                                        <img src="<?php echo esc_url($gal_image['sizes']['large']); ?>" alt="<?php echo esc_attr($gal_image['alt']); ?>" />
                                    </div>
                                <?php endforeach;
                            endif; ?>
                    </div>

                    <div class="product-info">
                    <br><p class="description">Opis:</p>

                        </div>
                        <div class="desc-prod">
                        <?php the_content(); ?>
                        </div>
                            <?php if (get_field('dimensions')) : ?>
                                <div class="first-product-desc">
                                    <?php if ($is_locale_en) :
                                        _e('Dimensions');
                                    ?>
                                    <?php else :
                                        _e('Wymiary produktu');
                                    ?>
                                    <?php endif; ?>
                                    <a class="number"><?php echo get_field('dimensions'); ?></a>
                                </div>
                                <?php if (get_field('weight')) : ?>
                                <div class="second-product-desc">
                                    <?php if ($is_locale_en) :
                                        _e('Weight');
                                    ?>
                                    <?php else :
                                        _e('Waga produktu');
                                    ?>
                                    <?php endif; ?>
                                    <a class="number"><?php echo get_field('weight'); ?></a>
                                </div>
                            <?php endif; ?>

                            <?php endif; ?>

                    </div>
                    <?php $basketImg = get_the_post_thumbnail_url();?>
                    <div class="add_to_cart_app"><add-to-cart></add-to-cart></div>
                     </article>
                <script>
                var currentProductObject = <?php echo json_encode(array(
                    'id' => get_the_ID(),
                    'image' => $basketImg,
                    'price' => (float)IDGTools::getPriceDiscounted($productPrice),
                    'priceFormatted' => IDGTools::getPriceDiscountedFormatted($productPrice),
                    'isDiscount' => IDGTools::isDiscount(),
                    'priceRegular' => (float)IDGTools::getPriceRegular($productPrice),
                    'priceRegularFormatted' => IDGTools::getPriceRegularFormatted($productPrice),
                    'name' => $productName,
                    'category' => $productLastCategory,
                )); ?>;
                </script>

            <?php endwhile; ?>
        <?php endif; ?>
        <div class="question">

<div class="text-question">
<p><img src="<?php echo IMG_URI; ?>logoMain.png" alt="LOGO" class="logo-question"></p>




<div class="question-text-wrapper">
<p class="question-title">Masz pytania?</p>
<span class="rest-text-question"><a href="tel:+48-602-243-666">zadzwoń +48 602 243 666</a></span><br>
<span class="rest-text-question mail"><a href="mailto:biuro@evg.pl">napisz biuro@evg.pl</a></span>
</div>

</div>
</div>

    </div>

</main>
</div>
<?php get_footer(); ?>
