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

    $(document).on("click", ".checkout-btn" , function() {
        $("#loading").show();
        var owner = {
            firstName: $('#firstName').val(),
            lastName: $('#lastName').val(),   
            email: $('#email').val(),
            address: {
                line1: $('#address1').val(),
                line2: $('#address2').val(),
                city: $('#city').val(),
                postalCode: $('#zip').val(),
                country: "US",
                state: "MN"
            }
        };
        var payload = {
            "type": "creditCard",
            "usage": "single",
            "owner":owner,
            "amount": 1,
            "currency": "USD"
        };
        if( userCheckoutOption != 'login' || ( userCheckoutOption == 'login' 
                && $('#paymentOption option:selected').val() == 'create_new' ) ) {  
            digitalriverjs.createSource(cardNumber,payload).then(function (result) {
                $("#loading").hide();
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
                    submit_form = 1;
                    cardDetails = result.source.creditCard;
                    sourceId = result.source.id;
                }
            }); //source
        }else{
            submit_form = 1;
            cardDetails = shoppersPayments[$('#paymentOption option:selected').val()];
        }
        $.validator.addMethod("inputFormat", function(value, element) {
            var specials = /[*|\":[\]{}`\\()';@?%=$]/;
            return this.optional(element) || !specials.test(value);
        }, "Illegal characters are not allowed in form fields");
        $.validator.addMethod("passFormat", function(value, element) {
            return this.optional(element) || /[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/.test(value);
        }, "Incorrect password format");
        $('form[name="billing_payment"]').validate({
            rules: {
                firstName: {
                    required: true,
                    inputFormat: true
                },
                lastName : {
                    required: true,
                    inputFormat: true
                },
                address1: {
                    required: true,
                    inputFormat: true
                },
                city: {
                    required: true,
                    inputFormat: true
                },
                zip: {
                    required: true,
                    inputFormat: true
                },
                country: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                verifyEmail: {
                    required: true,
                    equalTo: "#email"
                },
                password : {
                    required: true,
                    passFormat: true
                },
                verifyPassword: {
                    required: true,
                    equalTo: "#password"
                },
                phoneNum: {
                    required: true,
                    inputFormat: true
                },
                address_book_name: {
                    required: true,
                    inputFormat: true
                },
                paymentOptionName: {
                    required: true,
                    inputFormat: true
                },
                cardCvv: {
                    required: true,
                    number: true,
                    maxlength: 3
                } 
            },
            submitHandler: function() {
                setTimeout(function(){
                    if ( submit_form == 1 ) {
                        if ( userCheckoutOption == 'new_user' ) { 
                            // New User Flow
                            createShopper();
                        } else if( userCheckoutOption == 'login' ) {
                            // Login Flow
                            $("#loading").show();
                            updateShoppersDetails();
                        }else {
                            // Guest Checkout Flow
                            updateBillingAddress();
                        }
                    } else {
                        $("#loading").hide();
                        alert("Payment verification failed. Please try another time");
                    }
                }, 2500);
                return false;
            },
            messages: {
                firstName: {
                    required: "Enter the First Name",
                    inputFormat: "Illegal characters not allowed"
                },
                lastName: {
                    required: "Enter the Last Name",
                    inputFormat: "Illegal characters not allowed"
                },
                address1: {
                    required: "Enter the Address Line 1",
                    inputFormat: "Illegal characters not allowed"
                },
                city: {
                    required: "Enter the city",
                    inputFormat: "Illegal characters not allowed"
                },
                zip: {
                    required: "Enter the zip code",
                    inputFormat: "Illegal characters not allowed"
                },
                country: {
                    required: "Please select country"
                },
                email: {
                    required: "Enter the Email Address",
                    email: "Invalid Email Address"
                },
                verifyEmail: {
                    required: "Enter the Email Address",
                    equalTo: "Verify the Email Address"
                },
                password: {
                    required: "Enter the password",
                    inputFormat: "Incorrect password format"
                },
                verifyPassword: {
                    required: "Enter the Verify Password",
                    equalTo: "Verify the Password"
                },
                phoneNum: {
                    required: "Enter the phone number",
                    inputFormat: "Illegal characters not allowed"
                },
                address_book_name: {
                    required: "Enter the Book Name",
                    inputFormat: "Illegal characters not allowed"
                },
                paymentOptionName : {
                    required: "Enter the Payment Name",
                    inputFormat: "Illegal characters not allowed"
                },
                cardCvv: {
                    required: "Enter the card cvv",
                    number: 'Invalid Input',
                    maxlength: 'Invalid Input'
                }
            },
            invalidHandler: function(event, validator) {
                $("#loading").hide();
            }
        });
    });
    // $(document).on("click", "#userLogin" , function() {
    //     $('form[name="user_login"]').validate({
    //         rules: {
    //             user_email: {
    //                 required: true,
    //                 email: true
    //             },
    //             user_pass : {
    //                 required: true
    //             }
    //         },
    //         submitHandler: function() {
    //             userLogin();
    //             return false;
    //         },
    //         messages: {
    //             user_email: {
    //                 required: "Enter the Email Address",
    //                 email: "Invalid Email Address"
    //             },        
    //             user_pass: {
    //                 required: "Enter the password"
    //             }
    //         }
    //     });
    // });
    $(document).on("click", "#forgot_pass_btn" , function() {
        $('form[name="forgot_pass"]').validate({
            rules: {
                forgotemail: {
                    required: true,
                    email: true
                },
                verifyForgotemail : {
                    required: true,
                    equalTo: "#forgotemail"
                }
            },
            submitHandler: function() {
                return false;
            },
            messages: {
                forgotemail: {
                    required: "Enter the Email Address",
                    email: "Invalid Email Address"
                },        
                verifyForgotemail: {
                    required: "Enter the Email Address",
                    equalTo:  "Verify the Email Address"
                }
            }
        });
    });
    $('#address_book').on('change', function (e) {
        if ( this.value == 'create_new' ) {
            $("#firstName").val('');
            $("#lastName").val('');
            $("#city").val('');
            $("#zip").val('');
            $("#country").val('');
            $("#address1").val('');
            $("#address2").val('');
            $("#phoneNum").val('');
            $('#user_add_book_name').show();
        } else {
            $('#user_add_book_name').hide();
            setBillingInfoOptions( shoppersAddress[ this.value ]);
       }
    });
    $('#paymentOption').on('change', function (e) {
        if ( this.value == 'create_new' ) {
            $("#card_cvv_wrap").show();
            cardNumber.mount('card-number');
            cardExpiration.mount('card-expiration');
            cardSecurityCode.mount('card-cvv');
            $("#user_payment_name").show();
            $("#cardLastDigit").hide();
            $("#cardExpire").hide();
            $("#cardCvv").hide();
        } else {
            var paymentOption = shoppersPayments[ this.value ];
            cardNumber.unmount('card-number');
            $("#cardLastDigit").show();
            $("#cardLastDigit").val('************'+paymentOption['lastFourDigits']);
            cardExpiration.unmount('card-expiration');
            $("#cardExpire").show();
            $("#cardExpire").val(paymentOption['expirationMonth']+'/'+paymentOption['expirationYear']);
            cardSecurityCode.unmount('card-cvv');
            $("#card_cvv_wrap").hide();
            $("#user_payment_name").hide();
        }
    });
});
function createAccount(checkoutOption) {
    if ( checkoutOption == 'guest' || checkoutOption == 'login' ) {
        $("#billing_pass, #billing_confirm_pass").hide();
    }
    if ( checkoutOption == 'login'  ) {
        $("#loginInfo, #user_add_book_name, #email_option, #userLoginLink").hide();
        $('#user_address_option, #userLogoutLink').css('display', 'flex');
        $('#user_payment_option, #user_payment_name').show();
    } else {
        $("#loginInfo, #email_option").show();
    }
    userCheckoutOption = checkoutOption;
    document.getElementById('billing_info').style.display = "block";
    document.getElementById('createAccount').style.display = "none";
}
function update_lineitem( lineitem_id , product_id, qty_field ) {
    var action = 'update';
    var qty = $("#"+qty_field).val();
    var url =  updateLineItemUrl;
    $("#loading").show();
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            'lineitem_id': lineitem_id,
            'qty' : qty,
            'access_token' : access_token,
            'action' : action,
            'product_id' : product_id
        },
        dataType : 'html',
        success: function(data) {
            var cartData = JSON.parse(data);
            $("#"+cartData.lineitem_id+"_price").html(cartData.lineitem_price);
            $("#"+cartData.lineitem_id+"_price_mob").html(cartData.lineitem_price);
            $("#cartSubtotal").html(cartData.subtotal);
            $("#cartShippingCharges").html(cartData.shipping_charges);
            $("#loading").hide();
        },
        error: function(){
            alert('Error!!! Somthing went wrong');
            $("#loading").hide();
        }
     });
}

function remove_lineitem( lineitem_id ) {
    var url = removeLineItemUri;
    $("#loading").show();
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            'lineitem_id': lineitem_id,
            'access_token' : access_token
        },
        dataType : 'html',
        success: function(data) {
            var cartData = JSON.parse(data);
            if ( cartData.lineitem_count == 0 ) {
                $(".cart_details").hide();
                $("#empty_cart").show();
            } else {
                $("#"+cartData.lineitem_id+"_wrap_mob, #billing_info").hide();
                $("#"+cartData.lineitem_id+"_wrap").hide();
                $("#"+cartData.lineitem_id+"_price").html(cartData.lineitem_price);
                $("#"+cartData.lineitem_id+"_price_mob").html(cartData.lineitem_price);
                $("#cartSubtotal").html(cartData.subtotal);
                $("#cartShippingCharges").html(cartData.shipping_charges);
            }
            $("#loading").hide();
        },
        error: function(){
            alert('Error!!! Somthing went wrong');
            $("#loading").hide();
        }
    });
}

function updateBillingAddress(){
     $("#loading").show();
     var url =  updateBillingDetailsUri;
     var billing_details = JSON.stringify({                                                   
        "address": {
            "firstName": $('#firstName').val(),
            "lastName": $('#lastName').val(),   
            "city": $('#city').val(), 
            "countrySubdivision": "NA",
            "postalCode": $('#zip').val(),
            "country": "US",
            "countryName": "USA",                         
            "line1": $('#address1').val(),
            "line2": $('#address2').val(),
            "phoneNumber": $('#phoneNum').val(),
            "emailAddress": $('#email').val(),
        }
    });
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            'access_token' : access_token,
            'address_details' : billing_details
        },
        dataType : 'html',
        success: function(data) {
            var cartData = JSON.parse(data);
            updatePaymentMethods();
        },
        error: function(){
            alert('Error!!! Somthing went wrong');
            $("#loading").hide();
        }
    });
}
function updatePaymentMethods(){
    sourcePayment = JSON.stringify({
        "paymentMethod": {
            "sourceId": sourceId
        }
    });
    $("#loading").show();
    var url =  updatePaymentMethodsUri;
    $.ajax({
         url: url,
         type: 'POST',
         data: {
             'access_token' : access_token,
             'source_id' : sourceId,
             'card_details' : cardDetails,
             'userCheckoutOption' : userCheckoutOption
         },
         dataType : 'html',
         success: function(data) {
            var cartData = JSON.parse(data);
            $("#cartReviewOrder").html(cartData.review_order);
            $("#cartReviewOrder").show();
            $("#cartCheckout").hide();
            $("#loading").hide();
         },
         error: function(){
            alert('Error!!! Payment methods not applied');
            $("#loading").hide();
        }
    });
}

function submitCart() {
    var url =  submitCartUri;
    if( !$('#acceptTerms').is(":checked") ) {
        $("#acceptTermsError").show();
    } else {
        $("#loading").show();
        $("#acceptTermsError").hide();
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                'access_token' : access_token
            },
            dataType : 'html',
            success: function(data) {
                var cartData = JSON.parse(data);
                window.location.href = thankYouUrl+'?order_id='+cartData.orderId;
                $("#loading").hide();
            },
            error: function(){
                alert('Error!!! Somthing went wrong');
                $("#loading").hide();
           }
        });
    }
}

function createShopper(){
    var formData = $('form[name="billing_payment"]').serialize();
    var url = createShopperUrl;
    $("#loading").show();
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            'formData' : formData,
            'sourceId' : sourceId,
            'card_details' : cardDetails,
            'access_token' : access_token,
            'dr_session_token' : dr_session_token,
            'edit_cart': $("#edit_cart").val()
        },
        dataType : 'html',
        success: function(data) {
           var cartData = JSON.parse(data);
           if ( cartData.status == 'error' ) {
                alert(cartData.error_response);
           } else {
                $("#cartReviewOrder").html(cartData.review_order);
                $("#cartReviewOrder").show();
                $("#cartCheckout").hide();
                $("#loading").hide();
           }
           $("#loading").hide();
        },
        error: function(){
           alert('Error!!! Somthing went wrong');
           $("#loading").hide();
       }
    });                      
}

function userLogin(){
    var formData = $('form[name="user_login"]').serialize();
    var url = shopperLoginUrl;
    $("#loading").show();
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            'formData' : formData,
            'dr_session_token' : dr_session_token,
            'card_details' : cardDetails,
        },
        dataType : 'html',
        success: function(data) {
           var cartData = JSON.parse(data);
           if ( cartData.status == 'error' ) {
                alert(cartData.error_response);
           } else {
                // update the access_token
                oAuthToken = cartData.fullAccessToken;
                createAccount('login');
                // check for empty of address book
                var addressMethod = '<option value="create_new" >Create new address</option>';
                if ( cartData.shoppersAddresses == 'set_new' ) {
                    $("#user_add_book_name").show();
                } else {
                    $.each( cartData.shoppersAddresses, function( address_key, address_details ) {
                        if ( address_details['isDefault'] ) {
                            setBillingInfoOptions(address_details);
                            addressMethod += '<option value="'+address_details['id']+
                                '" selected>'+address_details['nickName']+'</option>';
                        } else {
                            addressMethod += '<option value="'+address_details['id']
                            +'">'+address_details['nickName']+'</option>';
                        }
                        shoppersAddress[address_details['id']] = address_details;
                    });
                }
                $("#address_book").html(addressMethod);
                
                var paymentOption = '<option value="create_new" >Create new address</option>';
                if ( cartData.shoppersPayment == 'set_new' ) {
                    $("#user_payment_name").show();
                }else{
                    $.each( cartData.shoppersPayment, function( payment_key, payment_details ) {
                        paymentOption += '<option value="'+payment_details['id']+
                                '">'+payment_details['nickName']+'</option>';
                        shoppersPayments[payment_details['id']] = payment_details['creditCard'];
                    });
                }
                $("#paymentOption").html(paymentOption);
           }
           $("#loading").hide();
        },
        error: function(){
           alert('Error!!! Somthing went wrong');
           $("#loading").hide();
       }
    });
}
function setBillingInfoOptions( addressDetails ) {
    $("#firstName").val(addressDetails['firstName']);
    $("#lastName").val(addressDetails['lastName']);
    $("#email").val($('#user_email').val());
    $("#city").val(addressDetails['city']);
    $("#zip").val(addressDetails['postalCode']);
    $("#country").val( ( addressDetails['countryName'] != null? 
                        addressDetails['countryName'].toLowerCase() : 'usa' ) );
    $("#address1").val(addressDetails['line1']);
    $("#address2").val(addressDetails['line2']);
    $("#phoneNum").val(addressDetails['phoneNumber']);
}

function updateShoppersDetails(){
    $("#loading").show();
    var url =  updateShoppersDetailsUrl;
    var billing_details = JSON.stringify({
        "nickName": ( $('#address_book_name').val()!= ''?$('#address_book_name').val()
                    :$('#address_book option:selected').html()),
        "firstName": $('#firstName').val(),   
        "lastName": $('#lastName').val(),   
        "city": $('#city').val(), 
        "countrySubdivision": "NA",
        "postalCode": $('#zip').val(),
        "country": "US",
        "countryName": "USA",                         
        "line1": $('#address1').val(),
        "line2": $('#address2').val(),
        "phoneNumber": $('#phoneNum').val(),
        "emailAddress": $('#email').val()
    });
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            'access_token' : oAuthToken,
            'sourceId' : sourceId,
            'paymentNickName' : $("#paymentOptionName").val(),
            'address_details' : billing_details,
            'paymentId' : $('#paymentOption option:selected').val(),
            'card_details' : cardDetails
        },
        dataType : 'html',
        success: function(data) {
            var cartData = JSON.parse(data);
            if ( cartData.status == 'error' ) {
                alert('Error..! Something went wrong. Please try again');
           } else {
                $("#cartReviewOrder").html(cartData.review_order);
                $("#cartReviewOrder").show();
                $("#cartCheckout").hide();
                $("#loading").hide();
            }
            
            $("#loading").hide();
        },
        error: function(){
            alert('Error!!! Somthing went wrong');
            $("#loading").hide();
        }
    });
}

function editCart(){
    $('#edit_cart').val('1');
    $("#cartReviewOrder").hide();
    $("#cartCheckout").show();
}
