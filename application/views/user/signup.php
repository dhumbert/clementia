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

<?php echo Form::open('user/create', 'POST', array('class' => 'form-horizontal')); ?>
  <?php echo Form::token(); ?>

  <div class="control-group">
    <?php echo Form::label('email', 'Email Address', array('class' => 'control-label')); ?>
    <div class="controls">
      <?php echo Form::text('email', Input::old('email'), array('class' => 'span4')); ?>
    </div>
  </div>

  <div class="control-group">
    <?php echo Form::label('password', 'Password', array('class' => 'control-label')); ?>
    <div class="controls">
      <?php echo Form::password('password', array('class' => 'span4')); ?>
    </div>
  </div>

  <div class="control-group">
    <div class="controls">
      <button type="submit" class="btn btn-primary">Sign Up</button>
    </div>
  </div>

<?php echo Form::close(); ?>