
var STRIPE_PUBLIC_KEY = 'pk_test_JAuLYhUdUySY4IE2nghytXW6';
var $form = null;

var MyStripe = {
    init: function(options){
        Stripe.setPublishableKey(STRIPE_PUBLIC_KEY);
        $form = $(options.form_selector);
    },
    success: function(callback){
        $form.submit(function(event) {
            event.preventDefault();
            // Disable the submit button to prevent repeated clicks
            var button = $form.find('button[type=submit]');
            button.prop('disabled', true);
            Stripe.card.createToken($form, function(status, response){
                if (response.error) {
                    $form.find('.payment-errors').text(response.error.message);
                    button.prop('disabled', false);
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




