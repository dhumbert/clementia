/**
 * When a link has the data-method attribute,
 * create a fake form that posts to the url with a _method
 * field. This allows us to fake PUT, POST, and DELETE requests
 * with links.
 */
define([
    "dojo/query", 
    "dojo/dom-attr", 
    "dojo/dom-construct",
    "dojo/dom-class",
    "dojo/on",
    "dojo/domReady!"
    ], function (query, domAttr, domConstruct, domClass, on) {
    
    query('a[data-method]').forEach(function(node){
        var href = domAttr.get(node, 'href');
        var method = domAttr.get(node, 'data-method');
        var token = domAttr.get(node, 'data-token');

        var newNode = "\n<form action='"+href+"' method='POST' style='display:none'>\n"+
        "   <input type='hidden' name='csrf_token' value='"+token+"'>\n"+
        "   <input type='hidden' name='_method' value='"+method+"'>\n"+
        "</form>\n"

        domConstruct.place(newNode, node);
        //domClass.add(node, 'http-method-link');
        domAttr.set(node, 'href', '#');

        on(node, 'click', function(e){
            query('form', node)[0].submit();
        });
    });
});