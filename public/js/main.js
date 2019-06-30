/*global $ */
/*eslint-env browser*/
//========================Load=====================//
/* navbar
======================= */
$(document).ready(function () {
    "use strict";
    $(".login").addClass('active');
    
    $(".side-nav .control-side").click(function () {
        $(this).toggleClass("active");
        $('body').toggleClass("side-bar-icon");
    });
    $(".side-nav .control-side").click(function () {
        if( !$("body").hasClass("side-bar-icon" ) ){
            $(".main-panel").addClass("hide-phone");
        }else{
            $(".main-panel").removeClass("hide-phone");
        }
    });
    $('#accordionNav li a img').click(function (){
         if($("body").hasClass("side-bar-icon" )){
             $("body").removeClass("side-bar-icon" );
         }
    });
    
    
    
    
    
    $(".notif-btn,.custom-date,.countCard").click(function () {
        $(this).toggleClass("active");
    });
    $(".search__nav .icon").click(function () {
        $('.filterWidget').toggleClass("active");
    });
    
    $(window).click(function() {
        $(".notif-btn, .custom-date,.countCard,.filterWidget").removeClass("active");
    });
    
    $('.sub-menu, .notif-btn , .custom-date, .showDate ,.countCard,.countDisplay,.filterWidget,.search__nav .icon').click(function(event){
        event.stopPropagation();
    });
    
    
    
    
    
    $('#add-type').keyup(function(){
        
        var type = $("#add-type").val();
        if(!(type == "")){
            $(".added-form .form-group .submit-add").show();
        }else{
            $(".added-form .form-group .submit-add").hide();
        }
    });
});

$(document).ready(function () {
    "use strict";
    function reStyle() {
        if ($(window).width() <= 770) {
            $('body').addClass("side-bar-icon");
        } else {
            $('body').removeClass("side-bar-icon");
        }
    }
    reStyle();
    $(window).resize(function () {
        reStyle();
    });
    
    
   
});
/* Alarts
===================== */
$(document).ready(function () {
    "use strict";
    $("#collapseTwo .custom-btn").click(function (){
        swal({
          title: "تم إنشاء القسم بنجاح",
          text: "يمكنك الان البدء في اضافه حساباتك داخل القسم الجديد واضافة اختصاراتك!",
          icon: "success",
          button: "تم!",
        });
    });
    $(".added-form .custom-btn").click(function (){
         swal({
          title: "تم  اضافة التنصيف بنجاح",
          text: "يمكنك الان البدء في اضافه حساباتك داخل القسم الجديد واضافة اختصاراتك!",
          icon: "success",
          button: "تم!",
        });
    });
});
/* Delet alart
============================== */
$(document).ready(function () {
    "use strict";
    $(".delete").click(function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var token = $('#delete_form :input[name=\'_token\']').val();
        var id = $('#delete_form :input[name=\'data_id\']').val();
        var raw = $(this).parent().parent();

        swal({
            title: "هل انت متاكد من الحذف ؟",
            text: "بمجرد حذفها ، لن تكون قادرًا على استرداد هذا  مرة اخري!",
            icon: "warning",
            buttons: true,
            dangerMode: true,

        })
        .then((willDelete) => {
             if (willDelete) {
                 $.ajax({
                     url: url,
                     dataType: "json",
                     method: 'post',
                     data: {
                         "id": id,
                         "_method": 'DELETE',
                         "_token": token,
                     }
                 }).done(function (data) {
                     console.log(data);
                     if(data.success === true){
                        // $('#delete_form').submit();
                         raw.hide();
                         swal('تم الحذف بنجاح','','success');
                     }else{
                         swal('فشل الحذف ','','error');
                     }
                 });
             } else {
                 swal(" تم الغاء عملية الحذف!");
             }
         });
    });
});

/*
* change status
* */
$(document).ready(function () {
    "use strict";
    $(".ban").click(function(event){
        event.preventDefault();
        if($(this).children('i').attr('class') === 'fas fa-ban'){
            var title = "هل انت متاكد من الحظر ؟";
        }else{
            var title = "هل انت متاكد من إلغاء الحظر ؟";
        }

        var url = $(this).attr('href');
        var atr = $(this);

        swal({
            title: title,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
             if (willDelete) {
                 $.ajax({
                     url: url,
                     data: "json",
                 }).done(function (data) {
                     if(data.success === "true"){
                         if(data.message === "ban"){
                             atr.children('i').removeClass();
                             atr.children('i').addClass('fas fa-play');
                             atr.removeAttr('data-original-title');
                             atr.attr('data-original-title', 'إلغاء الحظر');
                             swal('تم الحظر بنجاح','','success');
                         }else{
                             atr.children('i').removeClass();
                             atr.children('i').addClass('fas fa-ban');
                             atr.removeAttr('data-original-title');
                             atr.attr("data-original-title", "حظر المستخدم");
                             swal('تم إلغاء الحظر بنجاح','','success');
                         }
                     }else{
                         swal(' فشل الحظر ','','error');
                     }
                 });
             } else {
                 swal(" تم الغاء العملية !");
             }
         });
    });
});

$(document).ready(function () {
    "use strict";
    $(".update").click(function(event){
        event.preventDefault();

        var url = $(this).attr('href');
        var data = $(this).attr('data-content');

        $(".editSpec :input[type='text']").val(data);

        $('.editSpec').removeAttr('action');

        $('.editSpec').attr('action', url);
    });
});

$(document).ready(function () {
     "use strict";
    $(".countCard").click(function (){
       $(".countDisplay").toggleClass("active");
    });
});
/* Tooltip
================== */
$(document).ready(function(){
    "use strict";
  $('[data-toggle="tooltip"]').tooltip();
});
/* Popup imag profile
========================= */
$(document).ready(function () {
     "use strict";
    $('.userWorks img').click(function (){
        var getImg = $(this).attr('src');
        $('#img img').attr('src',getImg);
        console.log(getImg);
    });
});
/* slider 
======================== */
$(document).ready(function () {
     "use strict";
    $('.sliderProfile .slider').slick({
        arrows:true,
        nextArrow:".sliderControl .next",
        prevArrow:".sliderControl .prev",
        dots:false,
        autoplay:true,
        slidesToShow: 1,
        slidesToScroll: 1,
        speed:300,
        adaptiveHeight: true,
        autoplaySpeed: 2000,
        rtl:true
    });
});
/* Add active To aide nav
======================== */
$(document).ready(function () {
    "use strict";
    $("#accordionNav li a").each(function () {
            var t = window.location.href.split(/[?#]/)[0];
            this.href == t && ($(this).addClass("active"), $(this).parent().parent().parent().parent().children('a').addClass("active"));
        })
});

/* rating
======================== */
$(document).ready(function () {
    "use strict";
    var $rating = $('.rating'),
        ratingValue = $rating.attr('data-value'),
        floorValue = Math.floor(ratingValue),
        valueAfterPoint =  ratingValue - floorValue,
        unValue = 5 - ratingValue;
    for(var i =1; i <= ratingValue; i++){
        $rating.append('<li><i class="fas fa-star"></i></li>');
    }
    if(valueAfterPoint){
        $rating.append('<li><i class="fas fa-star-half-alt fa-flip-horizontal"></i></li>');
        for(var i =1; i < unValue; i++){
            $rating.append('<li><i class="far fa-star"></i></li>');
        }

    }else{
        for(var i =1; i <= unValue; i++){
            $rating.append('<li><i class="far fa-star"></i></li>');
        }
    }

});

    /*
    * get address modal
    * */

$(document).on('click', '.getTooltipData', function () {
    var data = $(this).attr('data-content');
    $('h3.tooltipData').html(data);
});


/* print
=================*/
function printcontent(divId) {
    var content = document.getElementById(divId).innerHTML;
    var mywindow = window.open('', 'Print', 'height=600,width=800');

    mywindow.document.write('<html dir="rtl"><head><title>فرصة تانية</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write(content);
    mywindow.document.write('</body></html>');

    mywindow.document.close();
    mywindow.focus()
    mywindow.print();
    mywindow.close();
    return true;
}
