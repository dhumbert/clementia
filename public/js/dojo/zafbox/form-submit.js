/**
 * When an element has the data-form-submit attribute, make the element click event
 * submit the form
 */
define([
    "dojo/query", 
    "dojo/dom-attr",
    "dojo/on",
    "dojo/domReady!"
    ], function (query, domAttr, on) {
    
    query('*[data-form-submit]').forEach(function(node){
        var form = domAttr.get(node, 'data-form-submit');

        on(node, 'click', function(e){
            query('form#'+form)[0].submit();
            return false;
        });
    });
});