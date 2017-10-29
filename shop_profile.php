<?php
/*Template Name: shop_profile*/
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
  html {margin-top: 0px !important;}
  *{margin: 0px; padding: 0px;}
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
  .v01 {
    background: url(http://mytemples.com/wp-content/uploads/2017/06/view_v01.jpg) center no-repeat;
  }
  .view {
    width: 100%;
    height: 140px;
    display: block;
    margin: 0 auto 20px;
    background-size: cover;
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
  .dataTemple li:first-child img {
    width: 100%;
    height: auto;
  }
  img {
      border: none;
      display: block;
  }
  .dataTemple li:nth-child(2) {
    width: calc(100% - 270px);
    padding: 20px;
    box-sizing: border-box;
  }
  .dataTemple li {
      float: left;
  }
  .dataTemple li:nth-child(2) h2 {
    margin: 0 0 20px;
  }
  h2 {
      font-size: 30px;
      font-weight: normal;
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
  a {
      text-decoration: none;
      border: none;
      outline: none;
      color: #;
      outline: none;
      hlbr: expression(this.onFocus=this.blur());
      cursor: pointer;
  }
  .fillData {
    position: relative;
    width: 100%;
    padding: 20px 20px 0px 20px;
    margin: 0 0 20px;
    background-color: rgba(255,255,255,0.6);
    box-shadow: 0 0 8px rgba(0,0,0,0.1);
    box-sizing: border-box;
  }
  .fillData h2 {
    position: relative;
    padding: 0 0 10px;
    margin: 0 0 20px;
    text-align: center;
    border-bottom: 1px solid #d3cabb;
  }
  h2 {
      font-size: 30px;
      font-weight: normal;
  }
  .fillData h2 .boxL {
    position: absolute;
    bottom: 10px;
    left: 0;
    font-size: 18px;
  }
  .fillData h2 .txt_org {
    font-weight: normal;
  }
  .txt_org {
      font-weight: bold;
      color: #ae2f11;
  }
  .tRight {
    text-align: right;
  }
  table td {
      padding: 5px 10px;
  }
  input[type="text"], input[type="password"] {
    height: 36px;
    line-height: 36px;
    padding: 0 10px;
    font-size: 18px;
    color: #55280d;
    border: none;
    background-color: #fff;
  }
  input {
      vertical-align: middle;
  }
  table tr td, .woocommerce table.shop_table td, .woocommerce-page table.shop_table td, .product_socials_wrapper, .woocommerce-tabs, .comments_section, .portfolio_content_nav #nav-below, .product_meta {
    border-top: 0;
  }
  .fillData h2 .boxL {
    position: absolute;
    bottom: 10px;
    left: 0;
    font-size: 18px;
  }
  .fillData h2 .txt_org {
    font-weight: normal;
  }
  .fillData h2 .boxR {
    position: absolute;
    bottom: 10px;
    right: 0;
    font-size: 18px;
  }
  input {
    vertical-align: middle;
  }
  input[type="checkbox"] + label, input[type="radio"] + label {
    display: inline-block;
    margin-left: 0.5rem;
    margin-right: 1rem;
    margin-bottom: 0;
    vertical-align: text-bottom;
  }
  li {
    list-style: none;
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
  .tCenter a {
      margin: 0 10px;
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
  .tCenter {
    text-align: center;
    margin: 0 auto 20px;
  }
  a.btn_bk{ font-size:14px; line-height:30px; padding:0 8px;  color:#fff; background-color:rgba(5,10,30,0.8); border-radius:2px; display:inline-block; transition:all 0.3s; vertical-align:middle;}
  a.btn_bk:hover{ color:#ffd43f; background-color:rgba(5,10,30,1);}
</style>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<link rel="stylesheet" href="http://mytemples.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="http://mytemples.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://mytemples.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

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
  var index = 0;
  function toOrder(id){
    <?php
      if (!get_current_user_id()) {?>
//        window.location.href = "http://mytemples.com/wp-login.php?redirect_to=http://mytemples.com/shop_profile/%3fuid=<?=$user_id?>%26bill=1";
     <?php
      }
    ?>
  //  $(".text_exposed_root").hide();
    
    closeTemplePop();
  //  var url = 'http://mytemples.com/order_step01/?temple_id='+id+'&seat_id='+seat_id;
  //  location = url;
    $(".btnSet02").hide();
    addPrayer();
    $(".tCenter").show();
  }

  var lights = '';
  
      
  <?php
    $i=0;
     foreach($loop->posts as $product_obj){
      $product_price = get_post_meta($product_obj->ID,'_price',true);
    ?>
  lights += '<li><input type="checkbox" id="prayerList__lights0<?=$i?>" name="prayerList_lights[][<?=$i?>]" value="<?=$product_obj->ID?>" <?php echo (($i==0)?"checked":"");?>> <label for="prayerList__lights0<?=$i?>"><?php if($product_obj) echo $product_obj->post_title;?> NT＄<?=$product_price?>元</label></li>';
  <?php
      $i++;
    }
  ?>

  function delPrayer(index){
    $("#prayer"+index).remove();
  }
  function addPrayer(){
    var html = '<div id="prayer'+index+'" class="fillData">';
    
    html += '<h2>祈福者資料'+(index+1);
    if(index>0){
      html += ' <a class="btn_bk" onclick="delPrayer('+index+');return false;">刪除</a>';
    }
    html += '<div class="boxL"><span class="txt_org">*</span>為必填資料</div>';
//    html += '<div class="boxR"><input type="checkbox" id="samePayer'+index+'" onclick="syncPayer('+index+',this.checked);"/><label for="samePayer'+index+'">同付款人</label></div>';
    html += '</h2>';
    html += '<div class="tb"><table width="100%">';
    html += '<tr><td class="tRight" width="120"><span class="txt_org">*</span>姓名:</td><td><input class="requireFld" type="text" name="prayerList_name['+index+']"></td></tr>';
    html += '<tr><td class="tRight"><span class="txt_org">*</span>出生日期:</td><td>';
    html += '<input class="requireFld" type="text" name="prayerList_birth_day['+index+']" id="prayerList_'+index+'_birth_day"></td></tr>';
      html += '<tr><td class="tRight">性別:</td><td><input type="radio" id="gender1_'+index+'" name="prayerList_gender['+index+']" value="1"> <label for="gender1_'+index+'">男</label> <input type="radio" id="gender2_'+index+'" name="prayerList_gender['+index+']" value="2"> <label for="gender2_'+index+'">女</label></td></tr>';
      html += '<tr><td class="tRight"><span class="txt_org">*</span>地址:</td><td><input  class="requireFld" class="full" type="text" name="prayerList_address['+index+']"></td></tr>';

      var prayerLights = lights.replace(/\[\]/g, '['+index+']').replace(/__/g, '_'+index+'_');
      html += '<tr><td class="tRight"><span class="txt_org">*</span>選擇燈別:</td><td><ul class="requireFlds">'+prayerLights+'</ul></td></tr>';
      
    html += '</table></div></div>';
    $("#prayerList").append(html);
    $('#prayerList_'+index+'_birth_day').datepicker({ dateFormat: 'yy-mm-dd' });

    if(0!=index){
      location.href="#prayer"+index;
    }
    index++;    

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
        <p></p>
        <div class="text_exposed_root"><?=$vendor_description?></div>
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

  <form method="post" id="command" name="step1Form" action="http://mytemples.com/mypay_test/">
  <input id="temple_id" name="temple_id" type="hidden" value="<?=$user_id?>">
  <div id="prayerList"></div>
  <div class="tCenter">
    <a class="btn_org" href="#" onclick="addPrayer();return false;">增加祈福者</a>
    <a class="btn_org" href="#" onclick="step2();return false;">訂單提交</a>
  </div>
  </form>
  <?php
    echo file_get_contents("http://mytemples.com/facebook_share/");
  ?>
</div>


<script type="text/javascript">
  function step2(){
    checkNeed = true;
    for(i=0; i<$(".requireFld").length; i++){
      if($(".requireFld").eq(i).val() == ""){
        checkNeed = false;
        fld_name = $(".requireFld").eq(i).parent().parent().children("td").eq(0).text();
        alert("Required Field '"+fld_name+"' is missing.");
        $(".requireFld").eq(i).focus();
        return false;
      }
    }
    for(i=0; i<$(".requireFlds").length; i++){
      checkSelect = false;
      check_obj = $(".requireFlds").eq(i);
      for(j=0; j<check_obj.children("li").length; j++){
        if(check_obj.children("li").eq(j).children("input:checked").length > 0)
          checkSelect = true;
      }
      if(checkSelect){

      } else {
        checkNeed = false;
        alert("Select at least one product.");
      }
    }
    
    if(checkNeed){
      step1Form.submit();
    }
  }
  <?php
  if(isset($_GET['bill'])){?>
  $(function(){
    toOrder("<?=$user_id?>");
  });
  <?php
    }
  ?>
  $(function(){
    $(".btnSet02").hide();
    addPrayer();
  });
</script>