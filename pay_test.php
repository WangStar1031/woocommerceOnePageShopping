<?php
/*Template Name: Pay_Test*/

  get_header();

    $successCheck = false;

    $bill_address = array(
        'first_name' => $_POST["bill_name"],
        'phone'      => $_POST["mobile"],
        'address_1'  => $_POST["address"]
    );

    $first_name = "";
    $birthday = "";
    $gender = "";
    $address_1 = "";

    if(count($_POST["prayerList_lights"]) == 0) exit();

    for($i=0; $i<count($_POST["prayerList_name"]); $i++){
        if($i){
            $first_name .= ", ";
            $birthday .= ", ";
            $gender .= ", ";
            $address_1 .= ", ";
        }
        $first_name .= $_POST["prayerList_name"][$i];
        $birthday .= $_POST["prayerList_birth_day"][$i];
        $gender .= (($_POST["prayerList_gender"][$i] == 1)?"Male":"Female");
        $address_1 .= $_POST["prayerList_address"][$i];
    }

    $ship_address = array(
            'first_name' => $first_name,
            'birthday'      => $birthday,
            'gender'      => $gender,
            'address_1'  => $address_1
    );

    $order = wc_create_order();
    $order->add_product( get_product( $_POST["prayerList_lights"][0] ), count($_POST["prayerList_name"]) );

    $order->set_address( $bill_address, 'billing' );
    $order->set_address( $ship_address, 'shipping' );
    $order->set_customer_id(get_current_user_id());

    $order->calculate_totals();

// mssql insert start

    $user_id = $_POST['temple_id'];

    $userinfo = get_userdata($user_id);
    $user_metainfo = get_user_meta($user_id);

    $vendor_shop_name = $user_metainfo["pv_shop_name"][0];
    $vendor_address = $user_metainfo["description"][0];

    $vendor_seller_info = $user_metainfo["pv_seller_info"][0];
    $vendor_description = $user_metainfo["pv_shop_description"][0];

    $vendor_name = $user_metainfo["nickname"][0];
    $vendor_email = $user_metainfo["billing_email"][0];
    $vendor_phone = $user_metainfo["billing_phone"][0];

    $product_id = $_POST["prayerList_lights"][0];

    $per_page = 20;        
    $args = array(
        'post_type' => 'product', 
        'posts_per_page' => 3, 
        'orderby' => 'ID', 
        'order' => 'DESC',
        'author' => $user_id,  
    );
    $product_obj = "";
    $loop = new WP_Query($args);
    foreach($loop->posts as $product){
    if($product_id == $product->ID){
      $product_obj = $product;
    }
    }
    $product_name = "";
    if($product_obj){
        $product_name = $product_obj->post_title;
    }
/*
    $myServer = "125.227.192.4";
    $myUser = "sa";
    $myPass = "wenhsuan01";
    $myDB = "LightingDB"; 

    ini_set('mssql.charset', 'UTF-8');

    $dbhandle = mssql_connect($myServer, $myUser, $myPass) or die("Couldn't connect to SQL Server on $myServer"); 
    
    $selected = mssql_select_db($myDB, $dbhandle) or die("Couldn't open database $myDB"); 
*/
    $payment_status = "0";

//    $product = mb_convert_encoding($product, "BIG5");
      
    for($i=0; $i<count($_POST["prayerList_name"]); $i++){
        $first_name = $_POST["prayerList_name"][$i];
        $birthday = $_POST["prayerList_birth_day"][$i];
        $gender = (($_POST["prayerList_gender"][$i] == 1)?"Male":"Female");
        $address_1 = $_POST["prayerList_address"][$i];
    
        $insert_val = "insert into [LightingDB].[dbo].[pendinglist] (  [Order_number], [Name], [phone], [vendor_address], [vendor_name], [product], [gender], [birthday], [order_date], [p_key_address], [payment_status], [vendor_location]) values ('".$order->id."',N'".$first_name."','".$_POST["mobile"]."','".$vendor_address."','".$vendor_name ."','" . $product_name . "','" .$gender."','" . $birthday . "','" . date("Y-m-d H:i:s") . "','" . $address_1 . "','" . $payment_status . "','" . $vendor_shop_name . "') ";

    //    echo $insert_val;
    //    $res = mssql_query($insert_val);

    }


// mssql insert end

    update_post_meta( $order->id, '_payment_method', 'Credit' );
    update_post_meta( $order->id, '_payment_method_title', 'Credit' );

    WC()->session->order_awaiting_payment = $order->id;
    $available_gateways = WC()->payment_gateways->get_available_payment_gateways();
    $result = $available_gateways[ 'ecpay' ]->process_payment( $order->id );

    $successCheck = ( $result['result'] == 'success' );
    $redirect_url = $result["redirect"];
    $redirect_url .= "&pay_for_order=true";

    if ( $successCheck ) {
        wp_redirect( $redirect_url );
        exit;
    }
?>