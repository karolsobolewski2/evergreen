<?php
/**
 * Template Name: kontakt
 * Description: kontakt template.
 */

get_header();
?>

<?php
    if (get_locale() == 'en_GB') echo do_shortcode('[Form id="7"]');
    else echo do_shortcode('[Form id="1"]');


    get_footer(); ?>
