$(document).on('click', '.status', function () {
    var status = $(this).attr('aria-pressed');
    var url = $(this).children('a').attr('href');

    $.ajax({
        url: url
    }).done(function (data) {
        if(status === 'true'){
            swal('تم التفعيل بنجاح','','success');
        }else{
            swal('تم الحظر بنجاح', '','success');
        }
    });
});

// $(document).on('click', '.delete', function (e) {
//     e.preventDefault();
//     var url = $(this).attr('href');
//
//     // table selected row
//     var raw = $(this).parent().parent();
//
//     $.ajax({
//         url: url,
//         data: "json",
//     }).done(function (data) {
//         if(data.success === true){
//             raw.hide();
//             swal('تم الحذف بنجاح','','success');
//         }else{
//             swal('فشل الحذف ','','error');
//         }
//     });
//
// });


