<?php
/**
 * The template for displaying popUp.
**/

?>
<?php
$sum = $j.$k;
?>
<article  class="add-cart-wrapper <?php if(strlen($sum) != 1){ echo 'add-cart-wrapper-50';} ?>" id="productCard-<?php echo $sum ?>">
    <span class="closer-pop" onclick="closePopup()"></span>
    <div class="photo-popup-wrapper" >
    <?php $basketImg = get_the_post_thumbnail_url();?>
        <img class="single-product-subcategory-img" src="<?php echo get_the_post_thumbnail_url(); ?>"/>    
    </div>
    <p class="popup-product-title"><?php $productName = get_the_title(); echo $productName ?></p>
    <div class="cart-wrapper">
        <div style="display: flex; justify-content: center; align-items:center; height: 100%;" >
            <!-- <div style="display: flex; justify-content: center; align-items: center;">
                <p style="font-size: 14px; font-weight: 700;">ilość</p>
                <input style="width: 150px; font-size: 14px; font-weight: 700; letter-spacing: 1.4px; height: 35px; margin: 0 15px; border: 1px solid rgba(112, 112, 112, 0.27); padding-left: 13px;" type="number">
            </div>
            <div style="display: flex; justify-content: center; margin-right: 30px; align-items: center; gap: 9px;">
                <input id="check" name="check" style="margin-left: 8px; border: 1px solid #D1D1D1; margin-bottom: -3px; margin-right: 5px;" class="print-option-checkbox" type="checkbox">
                <p for="check">nadruk</p>
            </div>
            <button class="popup-button"><add-to-cart>Dodaj do wyceny</add-to-cart></button> -->
            <!-- <div class="add_to_cart_app"><add-to-cart>+ dodaj do wyceny</add-to-cart></div> -->
            
            <div class="add_to_cart_app"><add-to-cart></add-to-cart></div>
            <script>
                var currentProductObject = <?php echo json_encode(array(
                    'id' => $productId= get_the_id(),
                    'name' => 'TEEEEEESt',
                    'image' => $basketImg,
                )); ?>;
            </script>
        </div>
    </div>
</article>

<script>
    var currentProductObject = <?php echo json_encode(array(
        'id' => $productId= get_the_id(),
        'name' => 'TEEEEEEEEST123123123',
        'image' => $basketImg,
    )); ?>;
</script>

