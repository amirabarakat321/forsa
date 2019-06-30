

/*"FOR PRJECTS in details page AmB";*/
$(" .profileAction li.deletedetailam a").click(function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    var ifdelete =1;

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
                    data: "json",
                }).done(function (data) {
                    //console.log(data.success);
                    if(data.success == true){
                        // $('#delete_form').submit();
                        ifdelete =2;
                        swal('تم الحذف بنجاح','','success');

                    }else{
                        swal('فشل الحذف ','','error');
                    }

                    if(ifdelete=== 2){

                        window.location.href = 'http://127.0.0.1:8000/project';
                    }
                });
            } else {
                swal(" تم الغاء عملية الحذف!");
            }
        });
});

$(document).ready(function () {
    $(".btn-toggle").click(function (e){
        e.preventDefault();
        var url = $(this).attr('href');
        var th = $(this) ;
        console.log(url);

        swal({
            title: "هل أنت متأكد من تغير الحالة ؟",
            text: "هل توافق علي تغير الحالة؟ ",
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
                            th.toggleClass('active');
                            swal("حسناً! تم التغير بنجاح",'','success');
                        }else{
                            swal('لقد فشل التغير','','error');
                        }
                    });
                    /*$(this).toggleClass('active');
                     swal("حسناً! تم التغير بنجاح", {
                         icon: "success",
                     });*/
                } else {
                    swal("حسناً! تم إلغاء عملية تغير الحالة");
                }
            });
    });


    $(".table-responsive table tr td a.deleteam").click(function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log(url);
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
                        data: "json",
                    }).done(function (data) {
                        //console.log(data.success);
                        if(data.success == true){
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

    /*"FOR PRJECTS in details page AmB";*/
    $(" .profileAction li.deletedetailam a").click(function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var ifdelete =1;

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
                        data: "json",
                    }).done(function (data) {
                        //console.log(data.success);
                        if(data.success == true){
                            // $('#delete_form').submit();
                            ifdelete =2;
                            swal('تم الحذف بنجاح','','success');

                        }else{
                            swal('فشل الحذف ','','error');
                        }

                        if(ifdelete=== 2){

                            window.location.href = 'http://127.0.0.1:8000/project';
                        }
                    });
                } else {
                    swal(" تم الغاء عملية الحذف!");
                }
            });
    });

});

$(document).ready(function () {
    "use strict";
    $(".updateadmin").click(function(event){
        event.preventDefault();

        var url = $(this).attr('href');
        var array = $(this).attr('data-content').split("-");
        console.log(array);

        document.getElementById('addminid').value =array[2] ;
        document.getElementById('addminname').value =array[0] ;
        document.getElementById('addminemail').value =array[1] ;
        document.getElementById('addminpass').value ="" ;
        document.myform.action = url;

         if(array[3]==1){
             $("#viewEd").attr('checked', true);
        }else{
             $("#viewEd").attr('checked', false);
         }
        if(array[4]==1){
            $("#deleteEd").attr('checked', true);
        }else{
            $("#deleteEd").attr('checked', false);
        }
        if(array[5]==1){
            $("#editEd").attr('checked', true);
        }else{
            $("#editEd").attr('checked', false);
        }
        if(array[6]==1){
            $("#addEd").attr('checked', true);
        }else{
            $("#addEd").attr('checked', false);
        }
    });
});


$(document).ready(function () {
    "use strict";
    $(".balancedetials").click(function(event){
        event.preventDefault();
        var array = $(this).attr('data-content').split("-");
        console.log(array);
        document.getElementById("bankname").innerHTML =array[0];
        document.getElementById("accnu").innerHTML =array[1];
        document.getElementById("processtype").innerHTML =array[2];
        document.getElementById("tatalbalance").innerHTML =array[3];
        document.getElementById("sitecommission").innerHTML =array[4];
        document.getElementById("uesrbalance").innerHTML =array[5];
        document.getElementById("sitebalance").innerHTML =array[6];
        document.getElementById("iban_nu").innerHTML =array[7];

    });
});



$(document).ready(function () {
    "use strict";
    $(".updattype").click(function(event){
        event.preventDefault();

        var array = $(this).attr('data-content').split("-");

        document.getElementById('tyname').value =array[0] ;
        document.getElementById('tyid').value =array[1] ;
    });
});


$(document).ready(function () {
    "use strict";
    $(".notifiView").click(function(event){
        event.preventDefault();
        var text = $(this).attr('data-content');
        document.getElementById("notifitext").innerHTML = text;
    });
});

$(document).ready(function () {
    "use strict";
    $(".sendMail").click(function(event){
        event.preventDefault();

        var array = $(this).attr('data-content').split("-");
        console.log(array[0]);
        document.getElementById('useremail').value =array[0] ;
        document.getElementById('username').value =array[1] ;
    });
});

$(document).ready(function () {
    "use strict";
    $(".updatebalance").click(function(event){
        event.preventDefault();

        var id = $(this).attr('data-content');

        document.getElementById('balance_id').value =id ;

    });
});

$(document).ready(function () {
    "use strict";
    $(".rechargebalance").click(function(event){
        event.preventDefault();

        var arra = $(this).attr('data-content').split("-");

        document.getElementById('balance_amount').value =arra[0] ;
        document.getElementById('add_balance_id').value =arra[1] ;

    });
});



$(document).ready(function () {
    "use strict";
    $(".deletebalance").click(function(event){
        event.preventDefault();
        var arra = $(this).attr('data-content').split("-");
        document.getElementById('delete_balance_amount_done').value =arra[0] ;
        document.getElementById('delete_balance_amount_view').value =arra[0] ;
        document.getElementById('delete_balance_id_done').value =arra[1] ;
        document.getElementById('delete_balance_id_view').value =arra[1] ;



    });
});



/*chat
========================*/
$(document).ready(function () {
    "use strict";
    $('.openChat .icon').click(function (){
        $('.openChat .chat').toggleClass('active');
    });

});



/* chat
==================== */
(function(){
    var x = $('.chat-history ul').height();
    $('.chat-history').scrollTop(x);

})();
