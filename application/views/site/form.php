<?php echo Form::label('domain', 'Domain'); ?>
<?php echo Form::text('domain', Input::old('domain', $site->domain), array('class' => 'span6')); ?>

<?php Section::start('additional_footer_content'); ?>
    <script>require(['clementia/validation'],
            function(validation){
                validation.validate('site-form', [{
                    name: 'domain',
                    rules: 'required|valid_url'
                }
                ])
            });
    </script>
<?php Section::stop(); ?>