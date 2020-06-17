$(document).ready(function(){
    var digitalriverjs = new DigitalRiver('pk_c1a984305e6e4d2a88fda776629c3acc');
    var options = {
        classes: {
            base: "DRElement",
            complete: "complete",
            empty: "empty",
            focus: "focus",
            invalid: "invalid",
            webkitAutofill: "autofill"
        },
        style: {
            base: {
                color: "#000",
                fontFamily: "Arial, Helvetica, sans-serif",
                fontSize: "13px",
                fontSmoothing: "auto",
                fontStyle: "normal",
                fontVariant: "normal",
                letterSpacing: "3px"
            },
            empty: {
                color: "#fff"
            },
            complete: {
                color: "green"
            },
            invalid: {
                color: "red",
            }
        }
    };
    var cardNumber = digitalriverjs.createElement('cardnumber', options);
    var cardExpiration = digitalriverjs.createElement('cardexpiration', options);
    var cardSecurityCode = digitalriverjs.createElement('cardcvv', options);
    cardNumber.mount('card-number');
    cardExpiration.mount('card-expiration');
    cardSecurityCode.mount('card-cvv');

    $(".field").bind('mouseout', function (event) {
        if ($('#card-number').hasClass("complete")) {
            $('#cardNumberError').empty();
        }
        if ($('#card-expiration').hasClass("complete")) {
            $('#cardExpirationError').empty();
        }
        if ($('#card-cvv').hasClass("complete")) {
            $('#cardSecurityError').empty();
        }
    });

    
    $( "iframe[id^='cardnumber']" ).append($("style[id='payment_iframe_style']"));

    var sourceId = 0;
    $('#accountForm').submit(function(event){
        
        var $form = $(this);
        if(!sourceId) {
            event.preventDefault();

            var owner = {
                firstName: $('input[name="firstName"]').val(),
                lastName: $('input[name="lastName"]').val(),   
                email: $('textarea[name="email"]').val(),
                address: {
                    line1: $('input[name="address1"]').val(),
                    line2: $('input[name="address2"]').val(),
                    city: $('input[name="city"]').val(),
                    postalCode: $('input[name="zip"]').val(),
                    country: "US",
                    state: $('select[name="state"]').val(),
                }
            };
    
            var payload = {
                "type": "creditCard",
                "usage": "single",
                "owner":owner,
                "amount": 1,
                "currency": "USD"
            };
    
            //$('#paymentOption option:selected').val() == 'create_new'
            if($('#paymentOptionName').length) {
                digitalriverjs.createSource(cardNumber,payload).then(function (result) {
                    // $("#loading").hide();
                    if (result.error) {
                        for (var i = 0; i < (result.error.errors.length); i++) {
                            if (result.error.errors[i].code.match("incomplete_card_number")) {
                                $("#cardNumberError").html(result.error.errors[i].message);
                            }
                            else if (result.error.errors[i].code.match("incomplete_expiration_date")) {
                                $("#cardExpirationError").html(result.error.errors[i].message);
                            }
                            else if (result.error.errors[i].code.match("incomplete_security_code")) {
                                $("#cardSecurityError").html(result.error.errors[i].message);
                            }
                            else if (result.error.errors[i].code.match("invalid_card_number")) {
                                $("#cardNumberError").html(result.error.errors[i].message);
                            }
                            else if (result.error.errors[i].code.match("invalid_expiration_month")) {
                                $("#cardExpirationError").html(result.error.errors[i].message);
                            }                   
                        }
                    } else {
                        cardDetails = result.source.creditCard;
                        sourceId = result.source.id;
                        $('input[name="paymentSourceId"]').val(sourceId);
                        console.log($('input[name="paymentSourceId"]').val());
                        $form.submit();
                    }
                }); //source
            } else {
                // cardDetails = shoppersPayments[$('#paymentOption option:selected').val()];
                return true;
            }
        } else {
            return true;
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

});
