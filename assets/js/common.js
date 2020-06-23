function appendDataToConsole() {
    for (i = 0; i <= sessionStorage.length - 1; i++) {
        var key = sessionStorage.key(i);
        var val = JSON.parse(sessionStorage.getItem(key));
        $.each(val, function(index, value) {
            console.log(value.functionName);
        });
    }
}

$(document).ready(function(){

    $('#resetPassword').on('shown.bs.modal', function () {
        $(this).find('.form-control').trigger('focus');
    });

    if($('#resetPassword').data('trigger')) {
        $('#resetPassword').modal('show');
    }

    if($('#resetPasswordSubmit').length && $('#resetPasswordSubmit').data('trigger')) {
        $('#resetPasswordSubmit').modal('show');
    }

});
 // $(document).on("click", "#forgot_pass_btn" , function() {
    //     $('form[name="forgot_pass"]').validate({
    //         rules: {
    //             forgotemail: {
    //                 required: true,
    //                 email: true
    //             },
    //             verifyForgotemail : {
    //                 required: true,
    //                 equalTo: "#forgotemail"
    //             }
    //         },
    //         submitHandler: function() {
    //             return false;
    //         },
    //         messages: {
    //             forgotemail: {
    //                 required: "Enter the Email Address",
    //                 email: "Invalid Email Address"
    //             },        
    //             verifyForgotemail: {
    //                 required: "Enter the Email Address",
    //                 equalTo:  "Verify the Email Address"
    //             }
    //         }
    //     });
    // });