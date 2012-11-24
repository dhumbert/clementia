define([
    "dojo/query",
    "dojo/dom-construct",
    "dojo/domReady!"
    ], function(query, domConstruct){
        query('#add-attribute').on('click', function(e){
            var newNode = '<div class="row">'+
                    '<div class="span3">'+
                        '<label for="">Attribute</label>'+
                        '<input type="text" name="attributes[attr]">'+
                    '</div>'+
                    '<div class="span3">'+
                        '<label for="">Value</label>'+
                        '<input type="text" name="attributes[value]">'+
                    '</div>'+
                '</div>';
            var node = query('.attributes')[0];

            domConstruct.place(newNode, node);
        });
});