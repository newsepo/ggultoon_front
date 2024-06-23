$(document).ready(function () {
 //importJs.setting();
});

/*기본 세팅*/
let importJs = {
 setting: function () {
  /*버튼 토글*/
  $(".charged_tab")
   .children("span")
   .click(function () {
    $(".charged_tab>span").removeClass("active");
    $(".contents>.content").removeClass("active");
    $(this).addClass("active");
    if ($(this).hasClass("charge active")) {
        $(".content.charge").addClass("active");
        $("#edit-btn").hide();
    } else if ($(this).hasClass("use active")) {
        $(".content.use").addClass("active");
        $("#edit-btn").show();
    } else if ($(this).hasClass("disappear active")) {
        $(".content.disappear").addClass("active");
        $("#edit-btn").hide();
    }
   });

  $(".charge_tab")
   .children("span")
   .click(function () {
    $(".charge_tab>span").removeClass("active");
    $(".charge.content").children(".content").removeClass("active");
    $(this).addClass("active");

    if ($(".charge_tab").children("span").hasClass("coin active")) {
     $(".coin.content").addClass("active");
    } else if ($(".charge_tab").children("span").hasClass("mileage active")) {
     $(".mileage.content").addClass("active");
    }
   });
 },
};
