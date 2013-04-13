define([
    "dojo/query",
    "dojo/dom-style",
    "dojo/_base/array"
    ], 
    function(query, domStyle, dojoArray){
        return {
            makeEqual: function(selector, hasInner) { 
                query(selector).forEach(function(node){
                    var maxHeight = 0;
                    dojoArray.forEach(node.children, function(child){
                        var elemHeight = domStyle.get(child, "height");
                        if (elemHeight > maxHeight) maxHeight = elemHeight;
                    });

                    dojoArray.forEach(node.children, function(child){
                        // pass true to hasInner to signify
                        // that you actually want to adjust the height
                        // of the first immediate child of the current child
                        // for example:
                        // hasInner = true: .row > .cell > .cell-inner will be resized
                        // hasInner = false: .row > .cell will be resized
                        if (hasInner) {
                            child = child.children[0];
                        }
                        domStyle.set(child, "height", maxHeight + 'px');
                    });
                });
            }
        };
    }
);