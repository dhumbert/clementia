<?php Section::start('content'); ?>
  <div class="row">
    <div class="span4 offset4 login-form">
        <h1>Account</h1>
        <?php echo Form::open('user/index', 'PUT'); ?>
            <?php echo Form::token(); ?>

            <div class="control-group">
              <?php echo Form::label('email', 'Email Address', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo Form::text('email', Input::old('email', Auth::user()->email), array('class' => 'span4')); ?>
              </div>
            </div>

            <div class="control-group">
              <?php echo Form::label('password', 'Password', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo Form::password('password', array('class' => 'span4')); ?>
              </div>
            </div>

            <div class="control-group">
              <?php echo Form::label('password_confirmation', 'Confirm Password', array('class' => 'control-label')); ?>
              <div class="controls">
                <?php echo Form::password('password_confirmation', array('class' => 'span4')); ?>
              </div>
              <span class="help-block">Leave the password fields blank to keep your current password.</span>
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        <?php echo Form::close(); ?>
    </div>
</div>

<?php Section::stop(); ?>