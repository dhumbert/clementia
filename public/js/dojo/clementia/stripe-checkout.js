define([
    'dojo/query',
    'dojo/on',
    'dojo/dom-attr',
    'dojo/domReady!'
], function(query, on, domAttr) {
    return function(stripeKey) {
        query('.btn-plan-select').forEach(function(node) {
            on(node, 'click', function(e){
                var token = function(res){
                    document.getElementById('stripeToken').value = res.id;
                    document.getElementById('subscribeForm').submit();
                };

                StripeCheckout.open({
                    key: stripeKey,
                    address:     false,
                    amount:      domAttr.get(node, 'data-price').replace('.', ''),
                    currency:    'usd',
                    name:        'Clementia',
                    description: domAttr.get(node, 'data-name') + ' Subscription',
                    panelLabel:  'Subscribe for',
                    token:       token
                });

                return false;
            });
        });
    }
});