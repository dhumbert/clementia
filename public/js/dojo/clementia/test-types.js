define([
    "dojo/query",
    "dojo/dom-attr",
    "dojo/dom-style",
    "dojo/domReady!"
    ], 
    function(query, domAttr, domStyle){
        query('#type').on('change', function(e){
            var selected = domAttr.get(e.target, 'value');
            if (selected == '') {
                query('.test-type').forEach(function(node){
                    domStyle.set(node, 'display', 'none');
                });
            } else {
                domStyle.set(query('#test-type-'+selected)[0], 'display', 'block');
            }
        });
    }
);