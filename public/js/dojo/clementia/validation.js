define([
    "dojo/dom-style",
    "dojo/dom-attr",
    "dojo/dom-construct",
    "dojo/dom-class",
    "validatejs/validate"
    ], function (domStyle, domAttr, domConstruct, domClass){
        /* validate this form */
        // todo validate different test types

        return {
            validate: function(formId, rules) {
                var validator = new FormValidator(formId, rules, function (errors, event){
                    if (errors.length > 0) {
                        if (document.getElementById('validation-errors')) {
                            domConstruct.destroy('validation-errors');
                        }

                        var errorMsgNode = domConstruct.create("div");
                        domAttr.set(errorMsgNode, 'id', 'validation-errors');
                        domClass.add(errorMsgNode, 'alert alert-error');
                        domStyle.set(errorMsgNode, 'display', 'none');

                        var dismissNode = domConstruct.create("button");
                        domClass.add(dismissNode, "close");
                        domAttr.set(dismissNode, "data-dismiss", "alert");
                        dismissNode.innerHTML = "&times;";

                        var error_string = "";
                        for (var i in errors) {
                            error_string += errors[i].message + '<br />';
                        }

                        errorMsgNode.innerHTML = error_string;
                        domStyle.set(errorMsgNode, 'display', 'block');
                        domConstruct.place(errorMsgNode, formId, 'first');
                        domConstruct.place(dismissNode, errorMsgNode, "first");
                        return false;
                    } else {
                        return true;
                    }
                });
            }
        };
    }
);