define([
    "dojo/query",
    "dojo/on",
    "dojo/dom-attr",
    "dojo/domReady!"
    ], 
    function(query, on, domAttr){

        query('.clickable-element').forEach(function(node) {
            on(node, 'click', function(e){
                var url = domAttr.get(node, 'data-link');
                window.location.href = url;
            });
        });
    }
);