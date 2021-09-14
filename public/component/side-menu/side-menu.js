jQuery(function ($) {

  /*$(".sidebar-dropdown > a").click(function() {
    $(".sidebar-submenu").slideUp(200);
    if ($(this).parent().hasClass("active")) {
      $(".sidebar-dropdown").removeClass("active");
      $(this).parent().removeClass("active");
    } else {
      $(".sidebar-dropdown").removeClass("active");
      $(this).next(".sidebar-submenu").slideDown(200);
      $(this).parent().addClass("active");
    }
  });*/

  $("#close-sidebar").on('click', function() {
    $(".page-wrapper").removeClass("toggled");
  });
  
  $("#show-sidebar").on('click', function() {
    $(".page-wrapper").addClass("toggled");
  });
  
  $("#switch-to-video").on('click', function() {
    $(".user-chats").addClass("sp-hide");
    $(".chat-app-form").addClass("sp-hide");
    $(".sidebar-menu-selected").removeClass("sidebar-menu-selected");
    $(this).addClass("sidebar-menu-selected");
    $(".page-wrapper").removeClass("toggled");

  });

  $("#switch-to-chatting").on('click', function() {
    $(".user-chats").removeClass("sp-hide");
    $(".chat-app-form").removeClass("sp-hide");
    $(".sidebar-menu-selected").removeClass("sidebar-menu-selected");
    $(this).addClass("sidebar-menu-selected");
    $(".page-wrapper").removeClass("toggled");

  });

});