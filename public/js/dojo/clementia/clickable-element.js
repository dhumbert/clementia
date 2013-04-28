define([
    "dojo/query",
    "dojo/behavior",
    "dojo/dom-attr",
    "dojo/domReady!"
    ],
    function(query, behavior, domAttr){
        var clickableBehavior = {
            ".clickable-element": {
                onclick: function(e){
                    var element = query(e.target).closest('.clickable-element')[0];
                    var url = domAttr.get(element, 'data-link');
                    window.location.href = url;
                }
            }
        };

        behavior.add(clickableBehavior);
        behavior.apply();
    }
);