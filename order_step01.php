<?php
/*Template Name: Order_Step*/

  get_header();

  $user_id = $_GET['temple_id'];
  $product_id = $_GET['seat_id'];

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
  $product_obj = "";
  $loop = new WP_Query($args);
  foreach($loop->posts as $product){
    if($product_id == $product->ID){
      $product_obj = $product;
    }
  }
  $product_price = "";
  if($product_obj){
    $product_price = get_post_meta($product_id,'_price',true);
  }
?>

<style type="text/css">
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

  var lights = '';

  lights += '<li><input type="checkbox" id="prayerList__lights0" name="prayerList_lights[]" value="<?=$product_id?>" checked=""checked> <label for="prayerList__lights0"><?php if($product_obj) echo $product_obj->post_title;?> NT＄<?=$product_price?>元</label></li>';

  
  function delPrayer(index){
    $("#prayer"+index).remove();
  }
  
  function syncPayer(index, checked){//聯絡人資料copy至第一位祈福者資料
    if(checked){
    $("input[name='prayerList_name["+index+"]']").val($("#bill_name").val());
    $("input[name='prayerList_address["+index+"]']").val($("#address").val());
    }
  }

  var index = 0;
  function addPrayer(){
    var html = '<div id="prayer'+index+'" class="fillData">';
    
    html += '<h2>祈福者資料'+(index+1);
    if(index>0){
      html += ' <a class="btn_bk" onclick="delPrayer('+index+');return false;">刪除</a>';
    }
    html += '<div class="boxL"><span class="txt_org">*</span>為必填資料</div>';
    html += '<div class="boxR"><input type="checkbox" id="samePayer'+index+'" onclick="syncPayer('+index+',this.checked);"/><label for="samePayer'+index+'">同付款人</label></div>';
    html += '</h2>';
    html += '<div class="tb"><table width="100%">';
    html += '<tr><td class="tRight" width="120"><span class="txt_org">*</span>姓名:</td><td><input class="requireFld" type="text" name="prayerList_name['+index+']"></td></tr>';
    html += '<tr><td class="tRight"><span class="txt_org">*</span>出生日期:</td><td>';
    html += '<input class="requireFld" type="text" name="prayerList_birth_day['+index+']" id="prayerList_'+index+'_birth_day"></td></tr>';
      html += '<tr><td class="tRight">性別:</td><td><input type="radio" id="gender1_'+index+'" name="prayerList_gender['+index+']" value="1"> <label for="gender1_'+index+'">男</label> <input type="radio" id="gender2_'+index+'" name="prayerList_gender['+index+']" value="2"> <label for="gender2_'+index+'">女</label></td></tr>';
      html += '<tr><td class="tRight"><span class="txt_org">*</span>地址:</td><td><input  class="requireFld" class="full" type="text" name="prayerList_address['+index+']"></td></tr>';
      
      var prayerLights = lights.replace(/\[\]/g, '['+index+']').replace(/__/g, '_'+index+'_');
      html += '<tr><td class="tRight"><span class="txt_org">*</span>選擇燈別:</td><td><ul>'+prayerLights+'</ul></td></tr>';
      
    html += '</table></div></div>';
    $("#pyayerList").append(html);
    $('#prayerList_'+index+'_birth_day').datepicker({ dateFormat: 'yy-mm-dd' });

    if(0!=index){
      location.href="#prayer"+index;
    }
    index++;
  }
</script>
<div class="main">
<form method="post" id="command" name="step1Form" action="http://mytemples.com/pay_test/">
  <input id="temple_id" name="temple_id" type="hidden" value="<?=$user_id?>">
  <div class="view v01"></div>
  <div class="dataTemple">
    <ul>
      <li class="pic"><img src="<?=$vendor_main_img?>" width="600" height="400" alt=""></li>
      <li>
        <h2><?=$vendor_shop_name?></h2>
        <div class="btnSet">
          <a class="btn_line"><?php if($product_obj) echo $product_obj->post_title;?></a>
        </div>
      </li>
    </ul>
    <div class="clr"></div>
  </div>
  <div class="fillData">
    <h2>聯絡人資料(付款人)
      <div class="boxL"><span class="txt_org">*</span>為必填資料</div>
    </h2>
    <div class="tb">
      <table width="100%">
        <tbody><tr>
          <td class="tRight" width="120"><span class="txt_org">*</span>姓名:</td>
          <td>
            <input class="requireFld" id="bill_name" name="bill_name" type="text" value="">
          </td>
        </tr>
        <tr>
          <td class="tRight"><span class="txt_org">*</span>手機號碼:</td>
          <td>
            <input class="requireFld" id="mobile" name="mobile" type="text" value="" maxlength="10">
          </td>
        </tr>
        <tr>
          <td class="tRight"><span class="txt_org">*</span>地址:</td>
          <td>
          <input class="requireFld" id="address" name="address" class="full" type="text" value="">
          </td>
        </tr>
      </tbody></table>
    </div>
    <div style="height:5px;"></div>
  </div>
  <div id="pyayerList"></div>
  <div class="tCenter">
    <a class="btn_org" href="#" onclick="addPrayer();return false;">增加祈福者</a>
    <a class="btn_org" href="#" onclick="step2();return false;">訂單提交</a>
  </div>
  </form>
</div>
<script type="text/javascript">
  if(index==0){
    addPrayer();
  }

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
    if(checkNeed){
      step1Form.submit();
    }
  }
</script>