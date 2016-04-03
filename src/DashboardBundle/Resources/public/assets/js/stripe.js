
var STRIPE_PUBLIC_KEY = 'pk_test_JAuLYhUdUySY4IE2nghytXW6';
var $form = null;

var MyStripe = {
    init: function(options){
        Stripe.setPublishableKey(STRIPE_PUBLIC_KEY);
        $form = $(options.form_selector);
    },
    process: function(callback, callbackError){
        $form.submit(function(event) {
            event.preventDefault();
            // Disable the submit button to prevent repeated clicks
            var button = $form.find('button[type=submit]');
            button.prop('disabled', true);
            Stripe.card.createToken($form, function(status, response){
                if (response.error) {
                    var $errors = $form.find('#stripe-payment-errors');
                    $errors.text(response.error.message);
                    $errors.parent().removeClass('hide');
                    button.prop('disabled', false);
                    callbackError(response);
                }
                else{
                    var token = response.id;
                    $form.append($('<input type="hidden" id="stripe-token" name="stripeToken" />').val(token));
                    callback(token);
                }
            });
        });
    }
};




