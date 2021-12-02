<?php

/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till main content.
 */

//if ( ! is_ssl() && is_production() ) {
//    header( 'HTTP/1.1 301 Moved Permanently' );
//    header( "Location: https://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"] );
//    exit();
//}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <title><?php bloginfo('title'); ?></title>

    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="referrer" content="origin">
    <script src="https://kit.fontawesome.com/8beea19556.js" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <?php // Close tags in footer.php
    ?>
    <?php $is_locale_en = (get_locale() == 'en_GB') ? true : false; ?>
    <div class="navbar-menu">
    <div id="app">
        <header onscroll="myFunction()">
      
            <div class="logo">
                <a href="<?php if(get_locale() == 'en_GB') echo '/en'; else echo '/'; ?>">
                <img class="logo-second" src="<?php echo IMG_URI; ?>logosecond.svg"/>
                <img class="logo-first" src="<?php echo IMG_URI; ?>logoEve.png"/>
                </a>
            </div>
            <div class="menu-nav">
            <nav>
                <ul>
                    <li class="hamburger">
                         <span class="dashicons dashicons-menu-alt hamburger-icon"></span>

                         <span class="dashicons dashicons-no-alt exit-icon"></span>
                    </li>
                    
                    <?php wp_nav_menu(array(
                        'theme_location' => 'main',
                        'container' => false,
                        'menu_class' => 'navigation',
                        'before' => '<span class="hidden">',
                        'after' => '</span>'
                        // 'items_wrap' => '%3$s'
                    )); ?>

                </ul>
                
            </nav>
            </div>
           
            <div id="cart_app" class="cart__nav-wrap"><cart></cart></div>
            <div class="user-info">
            
               
                  
                </div>
            </div>
            <form class="search-form-nav" id="search-form" method="GET"><span class="before-search"></span>
            <input class="input-text-nav" name='s' value="<?php echo get_search_query(); ?>" placeholder="Wyszukaj" />
            </form>
            </div>
            
        </header>
        <div class="content-area">
            
          