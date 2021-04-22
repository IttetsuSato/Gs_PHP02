// ログインフォーム表示
$("body").on("click", "#btn_login", function(){
  $(".login_form").toggleClass('active');
});
$("body").on("click", "#btn_account", function(){
  $(".account_form").toggleClass('active');
});
$("body").on("click", ".batsu", function(){
  $(".form_area").removeClass('active');
});