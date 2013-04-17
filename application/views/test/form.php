<div class="row">
    <div class="span6">
        <?php echo Form::label('description', 'Description'); ?>
        <?php echo Form::text('description', Input::old('description', $test->description), array('class' => 'span6')); ?>
    </div>
    <div class="span6">
        <?php echo Form::label('url', 'URL'); ?>
        <?php echo Form::text('url', Input::old('url', $test->url ?: 'http://'), array('class' => 'span6')); ?>
    </div>
</div>

<div class="row">
    <div class="span6">
        <?php echo Form::label('type', 'Test Type'); ?>
        <?php
            if (count($types) > 1) {
                $types = array('' => 'Select a test type...') + $types;
                echo Form::select('type', $types, Input::old('type', $test->type), array('class' => 'span6'));
            } else {
                $key = key($types);
                $type = array_shift($types);
                echo Form::hidden('type', $key);
                printf('<em>%s</em>', $type);
            }
        ?>
        <?php  ?>
    </div>
</div>

<div id="test-type-text" class="test-type" style="display:none;">
    <div class="row">
        <div class="span6">
            <?php echo Form::label('options[text]', 'Text to Search For'); ?>
            <?php echo Form::text('options[text]', $test->option('text'), array('class' => 'span6')); ?>

            <label class="checkbox">
                <?php echo Form::checkbox('options[case_sensitive]', TRUE, $test->option('case_sensitive')); ?>
                Case Sensitive
            </label>
        </div>
    </div>
</div>

<div id="test-type-element" class="test-type" style="display:none;">
    <div class="row">
        <div class="span6">
            <h4>Find the Elements</h4>
            <span class="help-block">
                Choose how to select the element(s). You must select an HTML tag, 
                enter an ID, or both. Once the elements are selected they
                will be filtered according to the other criteria you select.
            </span>
        </div>

        <div class="span6">
            <h4>Filter the Elements</h4>
            <span class="help-block">
                Choose how to filter the element(s). After the elements are found using the HTML tag
                or ID you entered, they will be checked for the CSS class or inner text that you specify
                below. You can leave either or both of these blank, if you'd like.
            </span>
        </div>
    </div>
    
    <div class="row">
        <div class="span3">
            <?php echo Form::label('options[tag]', 'HTML Tag'); ?>
            <?php echo Form::select('options[tag]', Config::get('tests.tags'), $test->option('tag')); ?>
        </div>
        <div class="span3">
            <?php echo Form::label('options[id]', 'ID'); ?>
            <?php echo Form::text('options[id]', $test->option('id')); ?>
        </div>
        
        <div class="span3">
            <?php echo Form::label('options[attributes][class]', 'CSS Class'); ?>
            <?php echo Form::text('options[attributes][class]', $test->option('attributes')['class']); ?>
        </div>
        <div class="span3">
            <?php echo Form::label('options[inner_text]', 'Element Inner Text'); ?>
            <?php echo Form::text('options[inner_text]', $test->option('inner_text')); ?>
        </div>
    </div>
</div>

<?php Section::start('additional_footer_content'); ?>
    <script>require(['clementia/test-types']);</script>

    <script>
        require([
            "dojo/dom-style",
            "dojo/dom-attr",
            "dojo/dom-construct"
            ], function (domStyle, domAttr, domConstruct){
                /* validate this form */
                // todo abstract this into function
                // todo validate different test types

                var formId = 'test-form';

                var validator = new FormValidator(formId, [{
                        name: 'description',
                        rules: 'required'
                    }, 
                    {
                        name: 'url',
                        rules: 'required|valid_url'
                    },
                    {
                        name: 'type',
                        rules: 'required'
                    }
                ], function (errors, event){
                    if (errors.length > 0) {
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
            });
    </script>
<?php Section::stop(); ?>