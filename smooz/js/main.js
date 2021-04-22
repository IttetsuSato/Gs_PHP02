$("body").on("click", "#make_group", function(){
  $(".group_form").toggleClass('active');
});
$("body").on("click", ".batsu", function(){
  $(".form_area").removeClass('active');
});