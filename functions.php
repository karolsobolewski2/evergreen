<?php

use function PHPSTORM_META\map;

require_once 'inc/init.php';

/**
 * Custom theme functions
 */

function excerpt_continue_reading($more) {
    $post = get_post();
    return '&nbsp;&nbsp;' . '<a href="' . get_permalink($post->ID) . '">' . __('…Czytaj dalej') . '</a>';
}
add_filter('excerpt_more', 'excerpt_continue_reading');


function save_relationships($term_id) {
    echo $term_id;

    $query = new WP_Query(array(
        'post_type' => 'product',
        'posts_per_page' => -1,
        'tax_query' => array(array(
            'taxonomy' => 'import_category',
            'field' => 'term_id',
            'terms' => $term_id,
        ))
    ));

    $categories = array_map('intval', get_term_meta($term_id, 'category_wp', true));

    while ($query->have_posts()) {
        $query->the_post();
        wp_set_object_terms(get_the_ID(), $categories, 'category');
    }

    wp_reset_postdata();
}
add_action('edit_import_category', 'save_relationships', 99);


function add_get_val() {
    global $wp;
    $wp->add_query_var('min_price');
    $wp->add_query_var('max_price');
    $wp->add_query_var('order');
}
add_action('init','add_get_val');

function searchj8jr283983_template_redirect()
{
  $s = get_query_var( 's' );
  if ( is_search() && is_category() && !empty($s)  )
  {
    $url = new URLHelper($_SERVER['REQUEST_URI']);

    $url
        ->unsetQueryParameter('s')
        ->unsetQueryParameter('lang')
        ->setPath(get_search_link())
    ;

    wp_safe_redirect( (string)$url, 301 );
  }
}
add_action( 'template_redirect', 'searchj8jr283983_template_redirect' );

if( function_exists('acf_add_options_page') ) {
	acf_add_options_page();
}

if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array (
        'key' => 'group_5e3b3db095117',
        'title' => 'user',
        'fields' => array (
            array (
                'key' => 'field_5e3b3dd8d23ad',
                'label' => 'Rabat',
                'name' => 'discount',
                'type' => 'text',
                'instructions' => '(rabat w procentach bez znaku %)',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5e3b3e77d23ae',
                'label' => 'NIP',
                'name' => 'nip',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5e3b3e99d23af',
                'label' => 'Nazwa firmy',
                'name' => 'company_name',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'maxlength' => '',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'user_form',
                    'operator' => '==',
                    'value' => 'edit',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));

endif;


//hide stocks and prices from admin
add_action('acf/input/admin_head', 'my_acf_admin_head');
function my_acf_admin_head() {
    ?>
    <style type="text/css">
        .acf-field-5d8cf088d63bd, .acf-field-5d8cebd9d63bc {
            display: none;
        }
    </style>
    <?php
}


//Add columns to product post list
function add_acf_columns($columns) {
    return array_merge($columns, array(
        'db_name' => __ ('Baza'),
    ));
}
add_filter('manage_product_posts_columns', 'add_acf_columns', 111);

function product_custom_column($column, $post_id) {
    switch ($column) {
        case 'db_name':
            echo get_post_meta($post_id, 'db_name', true );
            break;
        // case 'end_date':
        //     echo get_post_meta ( $post_id, 'end_date', true );
        //     break;
    }
}
add_action('manage_product_posts_custom_column', 'product_custom_column', 111, 2);


if(function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => __('Import produktów'),
        'capability' => 'edit_posts',
        'parent_slug' => 'edit.php?post_type=product',
        'update_button' => __('Pobierz produkty', 'acf'),
        'updated_message' => __("Pobrano produkty", 'acf')
    ]);
}

add_action('acf/save_post', 'products_import', 9);
function products_import() {
    if (strpos(get_current_screen()->id, "acf-options-import-produktow") == true) {
        $db  = $_POST['acf']['field_5f8ec0d236966'];
        $ids = $_POST['acf']['field_5f8ec1b285339'];

        //normalize ids list
        $ids = str_replace(' ', '', $ids);
        $ids = preg_replace('~,{2,}~', ',', $ids); //replace multiple commas with one

        $postfields = array('ids' => $ids);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $_SERVER['SERVER_NAME'] . '/wp-content/themes/evergreen/integrations/' . $db . '/products.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //return the transfer as a string
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
        $output = curl_exec($ch);
        curl_close($ch);

        wp_update_post([
            'ID' => 1,
            'post_content' => $output
        ]);
	}
}


if(function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => __('Import z pliku'),
        'capability' => 'edit_posts',
        'parent_slug' => 'edit.php?post_type=product',
        'update_button' => __('Importuj produkty', 'acf'),
        'updated_message' => __("Zaimportowano zdjęcia", 'acf')
    ]);
}


if(function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => __('Import zdjęć'),
        'capability' => 'edit_posts',
        'parent_slug' => 'edit.php?post_type=product',
        'update_button' => __('Importuj zdjęcia', 'acf'),
        'updated_message' => __("Zaimportowano zdjęcia", 'acf')
    ]);
}

/* **** */
class IDGTools
{
    private static $userHasDiscount = false;
    private static $userDiscount = null;
    private static $isUserLoggedIn = null;

    public static function init() {
        self::$isUserLoggedIn = is_user_logged_in();
        if (self::$isUserLoggedIn) {
            $id = get_current_user_id();
            $discount = get_field( 'discount', "user_{$id}");
            if ($discount) {
                self::$userDiscount = (100 - (float)$discount) / 100;
                self::$userHasDiscount = true;
            }
        }
    }

    public static function isDiscount()
    {
        return self::$userHasDiscount;
    }

    public static function getPriceRegularFormatted($price)
    {
        return self::formatPrice(self::getPriceRegular($price));
    }

    public static function getPriceRegular($price)
    {
        return $price;
    }

    public static function getPriceDiscountedFormatted($price)
    {
        return self::formatPrice(self::getPriceDiscounted($price));
    }

    public static function getPriceDiscounted($price)
    {
        return self::$userHasDiscount
            ? self::$userDiscount * $price
            : $price
        ;
    }

    public static function displayPrice($price)
    {
        if (!$price) {
            echo __('brak ceny');
            return;
        }

        if (self::$userHasDiscount) {

            $discountPrice = self::$userDiscount * $price;
            $discountPriceFormatted = self::formatPrice($discountPrice);
            $priceFormatted = self::formatPrice($price);
            echo "<span class=\"product-price--regular\">{$priceFormatted}</span> ";
            echo $discountPriceFormatted;
            return;

        }
        echo self::formatPrice($price);
    }

    public static function formatPrice($price)
    {
        return number_format($price, 2) . ' zł';
    }

    public static function displayLoginForm()
    {
        echo do_shortcode(get_field('login_form', 'option'));
    }

    public static function getThumbnailSrc()
    {
        $src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' );
        return isset($src[0]) ? $src[0] : '';
    }
}




function wpd_subcategory_template( $template ) {
    $cat        = get_queried_object();
    $children   = get_terms( $cat->taxonomy, array(
        'parent'     => $cat->term_id,
        'hide_empty' => false
    ) );

    if( ! $children ) {
        $template = locate_template( 'product-list.php' );
    } elseif( 0 < $cat->category_parent ) {
        $template = locate_template( 'subcategory.php' );
    }

    return $template;
}
add_filter( 'category_template', 'wpd_subcategory_template' );



IDGTools::init();