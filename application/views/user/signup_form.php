<?php if ($signup_errors = Session::get('signup_errors')): ?>
  <div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <ul class="unstyled">
      <?php foreach ($signup_errors as $error): ?>
        <li><?php echo $error; ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<?php echo Form::open('user/signup', 'POST', array('id' => 'signupForm')); ?>
  <?php echo Form::token(); ?>

    <?php echo Form::email('email', Input::old('email'), array('class' => 'span4', 'placeholder' => 'Email Address', 'id' => 'signupEmail')); ?>
    <?php echo Form::password('password', array('class' => 'span4', 'placeholder' => 'Password', 'id' => 'signupPassword')); ?>
    <?php echo Form::password('password_confirmation', array('class' => 'span4', 'placeholder' => 'Confirm Password', 'id' => 'signupPasswordConfirmation')); ?>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary btn-large btn-block">Sign Up</button>

        <?php if (isset($in_lightbox)): ?>
            <div class="signup-cancel">
                <a href="javascript:void(0)" data-dismiss="modal">
                    &hellip; or cancel
                </a>
            </div>
        <?php endif; ?>
    </div>
<?php echo Form::close(); ?>


<?php Section::start('additional_footer_content'); ?>
    <script>require([
            'clementia/validation'],
            function(validation){
                validation.validate('signupForm', [
                    {
                        name: 'email',
                        rules: 'required|valid_email'
                    },
                    {
                        name: 'password',
                        rules: 'required'
                    },
                    {
                        name: 'password_confirmation',
                        display: 'password confirmation',
                        rules: 'required|matches[password]'
                    }
                ])
            });
    </script>
<?php Section::stop(); ?>