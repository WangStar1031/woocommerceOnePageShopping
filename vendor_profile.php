<?php
/*Template Name: Vendor_profile*/
  get_header();

  $user_id = $_GET['uid'];
  $userinfo = get_userdata($user_id);
  $user_metainfo = get_user_meta($user_id);

  $vendor_shop_name = $user_metainfo["pv_shop_name"][0];
  $vendor_address = $user_metainfo["description"][0];

  $vendor_seller_info = $user_metainfo["pv_seller_info"][0];
  $vendor_description = $user_metainfo["pv_shop_description"][0];

  $vendor_name = $user_metainfo["nickname"][0];
  $vendor_email = $user_metainfo["billing_email"][0];
  $vendor_phone = $user_metainfo["billing_phone"][0];

  $vendor_logo_img = $user_metainfo["shipping_first_name"][0];
  $vendor_main_img = $user_metainfo["shipping_last_name"][0];

  $per_page = 20;        
  $args = array(
    'post_type' => 'product', 
    'posts_per_page' => 3, 
    'orderby' => 'ID', 
    'order' => 'DESC',
    'author' => $user_id,  
  );
  $loop = new WP_Query($args);

?>
<style type="text/css">
  html {margin-top: 0px !important;}
  .top-headers-wrapper{display: none;}
  #page_wrapper{padding-top: 0px;}
  body, .st-content{background: url(http://mytemples.com/wp-content/uploads/2017/06/bg.jpg);}
  @media only screen and (max-width: 880px)
  .main {
      width: 100%;
      padding: 30px 20px;
      margin: 0 auto;
      box-sizing: border-box;
  }

  .main {
      max-width: 880px;
      padding: 30px 0;
      margin: 0 auto;
      font-size: 18px;
      word-break: break-all;
  }
  .v02 { background: url(http://mytemples.com/wp-content/uploads/2017/06/view_v02.jpg) center no-repeat;}
  .view {
    width: 100%;
    height: 140px;
    display: block;
    margin: 0 auto 20px;
    background-size: cover;
  }
  .intro {
    position: relative;
    width: 100%;
    padding: 20px;
    margin: 0 0 20px;
    font-size: 16px;
    background-color: rgba(255,255,255,0.6);
    box-shadow: 0 0 8px rgba(0,0,0,0.1);
    box-sizing: border-box;
  }
  .intro h2 {
    position: relative;
    padding: 0 0 10px;
    margin: 0 0 20px;
    text-align: center;
    border-bottom: 1px solid #d3cabb;
  }
  .intro .dataTemple {
    box-shadow: none;
    background: none;
  }
  .dataTemple {
      position: relative;
      width: 100%;
      margin: 0 0 20px;
      background-color: rgba(255,255,255,0.6);
      box-shadow: 0 0 8px rgba(0,0,0,0.1);
  }
  .clr {
    clear: both;
    display: block;
  }
  .intro .dataTemple li:first-child {
    width: 325px;
    height: calc(325px/1.5);
    text-align: center;
    display: block;
    overflow: hidden;
  }
  .intro .dataTemple ul li {
      margin: 0 0 15px;
  }
  .dataTemple li:first-child {
      width: 270px;
      height: 180px;
      text-align: center;
      display: block;
      overflow: hidden;
  }
  .dataTemple li {
      float: left;
  }
  .intro .dataTemple a.address {
    margin: 0 0 5px;
  }
  a.address {
      padding: 0 0 0 16px;
      color: #c14528;
      background: url(http://mytemples.com/wp-content/uploads/2017/06/bg_address.png) no-repeat;
      background-size: 12px auto;
  }
  a {
      text-decoration: none;
      border: none;
      outline: none;
      color: #;
      outline: none;
      hlbr: expression(this.onFocus=this.blur());
      cursor: pointer;
  }
  .intro .dataTemple .btnSet {
      margin: 5px 0 0;
  }
  .intro .dataTemple li:nth-child(2) {
    width: calc(100% - 325px);
    padding: 0 0 0 15px;
    box-sizing: border-box;
  }
  .intro .dataTemple ul li {
      margin: 0 0 15px;
  }
  .dataTemple li:nth-child(2) a.btn_line {
    margin: 0 4px 4px 0;
  }
  a.btn_line {
      font-size: 16px;
      line-height: 30px;
      padding: 0 4px;
      color: #c14528;
      background-color: rgba(255,255,255,0);
      border: 1px solid #c14528;
      border-radius: 2px;
      display: inline-block;
      transition: all 0.3s;
  }
  a.btn_line:hover{ color:#fff; background-color:rgba(193,69,40,1);}
  a.btn_line.on{ color:#fff; background-color:rgba(193,69,40,1);}
  .popOverlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: block;
    background-color: rgba(0,0,0,0.9);
    z-index: 111;
  }
  .pop {
    position: absolute;
    top: 100px;
    left: 50%;
    width: 430px;
    padding: 30px 60px;
    margin: 0 -225px;
    background-color: #fff;
    transition: all 0.3s;
    z-index: 112;
  }
  .pop a.close {
    position: absolute;
    top: 0;
    right: 0;
    width: 30px;
    height: 30px;
    display: block;
    background: #ae2f11 url(http://mytemples.com/wp-content/uploads/2017/06/bt_close.png) no-repeat;
    background-size: cover;
  }
  .pop h2 {
    text-align: center;
    margin: 10px 0 20px;
  }
  .pop .pic {
    margin: 0 0 20px;
  }
  .pop .pic img {
    width: 100%;
    height: auto;
  }
  .pop h3 {
    font-size: 18px;
    color: #ae2f11;
  }
  .pop p {
    line-height: 30px;
    margin: 0 0 10px;
  }
  .pop .btnSet02 {
    margin: 0 auto 20px;
    text-align: center;
  }
  a.btn_org {
    font-size: 18px;
    line-height: 50px;
    padding: 0 15px;
    color: #fff;
    background-color: #c14528;
    border-radius: 2px;
    display: inline-block;
    transition: all 0.3s;
  }
  .pop ul.ar {
    margin: 0 0 10px;
  }
  ul.ar li {
    padding: 3px 0 3px 16px;
    background: url(http://mytemples.com/wp-content/uploads/2017/06/icon_ar.png) 5px 10px no-repeat;
    text-align: left;
  }
  .txt_bk {
    font-weight: bold;
    color: #000;
  }
  .txt_org {
    font-weight: bold;
    color: #ae2f11;
  }
</style>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>
  $ = jQuery;
  var temple_id = null;
  var seat_id = null;

  function openTemplePop(id, index){
    if(!index){
      index = 0;
    }
    temple_id = id;
    var lights = $("#templePop"+id+" .btn_line");
    var _seat_id = lights[index].id;
    _seat_id = _seat_id.substring(_seat_id.indexOf('-')+1);
    choiceLight(_seat_id);
    $("#templePop"+id).show();
    $("#templePop"+id+" .pop").css('top',$(window).scrollTop()+100);
  }
  function closeTemplePop(){
  $(".templePop").hide();
  }
  function choiceLight(id){
    seat_id = id;
    $(".btn_line").removeClass("on");
    $lightElem = $("#light"+temple_id+"-"+seat_id);
    $lightElem.addClass("on");
    $("#lightPic"+temple_id).attr("src", $lightElem.attr("src"));
    $("#lightName"+temple_id).html($lightElem.html());
    var data = $lightElem.attr("alt").split("|");
    $("#lightDesc"+temple_id).html(data[0]);
    $("#lightPrice"+temple_id).html(data[1]);
  }
  function toOrder(id){
    var url = 'http://mytemples.com/order_step01/?temple_id='+id+'&seat_id='+seat_id;
    location = url;
  }

  </script>
<div class="main">
  <div class="view v02"></div>
  <div class="temple">
    <div class="intro">
      <h2><?=$vendor_shop_name?></h2>
      <div class="dataTemple">
        <ul>
          <li class="pic"><img src="<?=$vendor_main_img?>" width="600" height="400"></li>
          <li>
            <a class="address" href="#"><?=$vendor_address?></a>
            <p>主祀神祇 ： <?=$vendor_name?></a></p>            
            <p>電子郵件 ： <?=$vendor_email?> </p>            
            <p>電話號碼 ： <?=$vendor_phone?> </p>
            <div class="btnSet"> 
            <?php 
              $i=0;
              foreach($loop->posts as $product){
            ?>
                <a class="btn_line" href="#" onclick="openTemplePop('<?=$user_id?>',<?=$i++?>);return false;"><?=$product->post_title?></a>
            <?php }?>
             </div>
          </li>
        </ul>
        <div class="clr"></div>
        <p></p><div class="text_exposed_root"><?=$vendor_description?></div>
    </div>
  </div>
  <div id="templePop<?=$user_id?>" class="templePop" style="display: none;">
    <div class="popOverlay" onclick="closeTemplePop();return false;"></div>
    <div class="pop" style="top: 500px;">
      <a href="#" class="close" onclick="closeTemplePop();return false;"></a>
      <h2><?=$vendor_shop_name?></h2>
      <div class="pic"><img id="lightPic<?=$user_id?>" src="<?=$vendor_main_img?>" width="600" height="400" alt=""></div>
      <div class="btnSet01">
  <?php foreach($loop->posts as $product){    
      $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->ID ), 'single-post-thumbnail' );    
      $product_price = get_post_meta($product->ID,'_price',true);
   ?>
        <a id="light<?=$user_id?>-<?=$product->ID?>" class="btn_line" href="#" src="<?=$image[0]?>" alt="<?=$product->post_content?>|<?=$product_price?>" onclick="choiceLight('<?=$product->ID?>');return false;"><?=$product->post_title?></a>
  <?php }?>
      </div><br>
      <h3 id="lightName<?=$user_id?>"></h3>
      <p id="lightDesc<?=$user_id?>"></p>
      <ul class="ar">
        <li><span class="txt_bk">登記費用：</span>每盞燈新台幣<span class="txt_org" id="lightPrice<?=$user_id?>"></span>元</li>
      </ul>
      <div class="btnSet02"><a class="btn_org" onclick="toOrder('<?=$user_id?>');return false;">去點燈</a></div>
    </div>
  </div>
</div>