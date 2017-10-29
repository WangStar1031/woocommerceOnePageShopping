<?php
/*Template Name: My_Pay_Test*/

  get_header();

  session_start();

  $_SESSION["orderInfo"] = $_POST;

  if(count($_POST["prayerList_lights"]) == 0) exit();

    for($i=0; $i<count($_POST["prayerList_lights"]); $i++){
        foreach ($_POST["prayerList_lights"][$i] as $key => $product_id){
            $quantity = 1;

            if ( WC()->cart->add_to_cart( $product_id, $quantity ) ) {
                do_action( 'woocommerce_ajax_added_to_cart', $product_id );
                wc_add_to_cart_message( $product_id );
            } 
        }
    }
    
    $redirect_url = "http://mytemples.com/checkout";
    wp_redirect( $redirect_url );
?>