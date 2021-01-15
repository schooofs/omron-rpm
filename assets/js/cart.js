$(document).ready(function(){

    if($('.payment-options').length) {
        $('.payment-option-add-new').on('click', function(e) {
            e.preventDefault();
            
            $('#payment-option').slideDown('fast');
            $('#paymentOptionName').attr('required', true);
        });

        $('.payment-options').on('click', 'tbody tr', function(e) {

            if(!$(this).hasClass('default-payment')) {
                $('.table-overlay').show();
                $.post( updatePaymentUrl,
                {
                    paymentId: $(this).data('paymentId')
                },
                function(data){
                    if(data.success) {
                        location.reload();
                    } else {
                        $('.table-overlay').hide();

                    }
                });
            }
        });

        //Fix event bubbling in the above function
        $(".payment-options a").click(function(e) {
            e.stopPropagation();
        });
    }

    if ($('#payment-option').length ) {

        var digitalriverjs = new DigitalRiver('pk_c1a984305e6e4d2a88fda776629c3acc');
        const options = {
            classes: {
                base: 'DRElement',
                complete: 'DRElement--complete',
                empty: 'DRElement--empty',
                invalid: 'DRElement--invalid'
            },
            style: {
                base: getStyleOptionsFromClass('DRElement'),
                complete: getStyleOptionsFromClass('DRElement--complete'),
                empty: getStyleOptionsFromClass('DRElement--empty'),
                invalid: getStyleOptionsFromClass('DRElement--invalid')
            }
        };

        var cardNumber = digitalriverjs.createElement('cardnumber', options);
        var cardExpiration = digitalriverjs.createElement('cardexpiration', Object.assign({}, options, { placeholderText: 'MM/YY' }));
        var cardCVV = digitalriverjs.createElement('cardcvv', Object.assign({}, options, { placeholderText: 'CVV' }));

        cardNumber.mount('card-number');
        cardExpiration.mount('card-expiration');
        cardCVV.mount('card-cvv');

        cardNumber.on('change', function(evt) {
            activeCardLogo(evt);
            displayDRElementError(evt, $('#card-number-error'));
        });
        cardExpiration.on('change', function(evt) {
            displayDRElementError(evt, $('#card-expiration-error'));
        });
        cardCVV.on('change', function(evt) {
            displayDRElementError(evt, $('#card-cvv-error'));
        });

        function getStyleOptionsFromClass(className) {
            const tempDiv = document.createElement('div');
            tempDiv.setAttribute('id', 'tempDiv' + className);
            tempDiv.className = className;
            document.body.appendChild(tempDiv);
            const tempDivEl = document.getElementById('tempDiv' + className);
            const tempStyle = window.getComputedStyle(tempDivEl);

            const styles = {
                color: tempStyle.color,
                fontFamily: tempStyle.fontFamily.replace(new RegExp('"', 'g'), ''),
                fontSize: tempStyle.fontSize,
                height: tempStyle.height
            };
            document.body.removeChild(tempDivEl);

            return styles;
        }

        function activeCardLogo(evt) {
            $('.cards .active').removeClass('active');
            if (evt.brand && evt.brand !== 'unknown') {
                $(`.cards .${evt.brand}-icon`).addClass('active');
            }
        }

        function displayDRElementError(evt, $target) {
            if (evt.error) {
                $target.text(evt.error.message).show();
            } else {
                $target.text('').hide();
            }
        }

        $('#accountForm').submit(function(event){ 
            event.preventDefault();
            var $form = $(this);
            
            if( $('div#payment-option').css('display') != 'none' ) {
                var owner = {
                    firstName: $('input[name="firstName"]').val(),
                    lastName: $('input[name="lastName"]').val(),   
                    email: $('input[name="email"]').val(),
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
                    "owner":owner
                };

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
                        $form[0].submit();
                    }
                }); //source
            } else {
                $form[0].submit();
            }
        });
    }
});


function getStyleOptionsFromClass(className) {
    const tempDiv = document.createElement('div');
    tempDiv.setAttribute('id', 'tempDiv' + className);
    tempDiv.className = className;
    document.body.appendChild(tempDiv);
    const tempDivEl = document.getElementById('tempDiv' + className);
    const tempStyle = window.getComputedStyle(tempDivEl);

    const styles = {
        color: tempStyle.color,
        fontFamily: tempStyle.fontFamily.replace(new RegExp('"', 'g'), ''),
        fontSize: tempStyle.fontSize,
        height: tempStyle.height
    };
    document.body.removeChild(tempDivEl);

    return styles;
}

function displayDRElementError(evt, $target) {
    if (evt.error) {
        $target.text(evt.error.message).show();
    } else {
        $target.text('').hide();
    }
}