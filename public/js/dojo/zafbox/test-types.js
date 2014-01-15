define([
    "dojo/query",
    "dojo/dom-attr",
    "dojo/dom-style",
    "dojo/domReady!"
    ], 
    function(query, domAttr, domStyle){
        var type = domAttr.get(query('#type')[0], 'value');
        show_selected(type);

        query('#type').on('change', function(e){
            query('.test-type').forEach(function(node) {
                domStyle.set(node, 'display', 'none');
            });

            var selected = domAttr.get(e.target, 'value');
            if (selected == '') {
                query('.test-type').forEach(function(node){
                    domStyle.set(node, 'display', 'none');
                });
            } else {
                show_selected(selected);
            }
        });

        function show_selected(type) {
            if (type != '') {
                domStyle.set(query('#test-type-'+type)[0], 'display', 'block');
            }
        }
    }
);