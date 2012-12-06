<h2>Sign Up</h2>

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

<?php echo Form::open('user/create', 'POST', array('class' => 'form-inline')); ?>
  <?php echo Form::token(); ?>

    <?php echo Form::email('email', Input::old('email'), array('class' => 'span4', 'placeholder' => 'Email Address')); ?>
    <?php echo Form::password('password', array('class' => 'span4', 'placeholder' => 'Password')); ?>

    <button type="submit" class="btn btn-primary">Sign Up</button>

<?php echo Form::close(); ?>