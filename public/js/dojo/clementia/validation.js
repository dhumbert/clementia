define([
    "dojo/dom-style",
    "dojo/dom-attr",
    "dojo/dom-construct",
    "validatejs/validate"
    ], function (domStyle, domAttr, domConstruct){
        /* validate this form */
        // todo validate different test types

        return {
            validate: function(formId, rules) {
                var validator = new FormValidator(formId, rules, function (errors, event){console.log(errors);
                    if (errors.length > 0) {
                        if (document.getElementById('validation-errors')) {
                            domConstruct.destroy('validation-errors');
                        }

                        var errorMsgNode = domConstruct.create("div");
                        domAttr.set(errorMsgNode, 'id', 'validation-errors');
                        domAttr.set(errorMsgNode, 'class', 'alert alert-error');
                        domStyle.set(errorMsgNode, 'display', 'none');

                        var error_string = "";
                        for (var i in errors) {
                            error_string += errors[i].message + '<br />';
                        }

                        errorMsgNode.innerHTML = error_string;
                        domStyle.set(errorMsgNode, 'display', 'block');
                        domConstruct.place(errorMsgNode, formId, 'first');
                        return false;
                    } else {
                        return true;
                    }
                });
            }
        };
    }
);