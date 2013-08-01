<?php echo Form::label('domain', 'Domain'); ?>
<?php echo Form::text('domain', Input::old('domain', $site->domain), array('class' => 'span6')); ?>

<?php Section::start('additional_footer_content'); ?>
    <script>require(['dojo/on', 'clementia/validation'],
            function(on, validation){

                on(document.getElementById('domain'), 'blur', function(evt){
                    if (evt.target.value.substr(0, 4) != 'http') {
                        evt.target.value = 'http://' + evt.target.value;
                    }
                });

                validation.validate('site-form', [{
                        name: 'domain',
                        rules: 'required|valid_url'
                    }
                ])
            });
    </script>
<?php Section::stop(); ?>