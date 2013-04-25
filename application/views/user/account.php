<?php Section::start('content'); ?>
    <div class="row">
        <div class="span4 offset4 login-form">
            <h1>Account</h1>
            <?php echo Form::open('user/index', 'PUT'); ?>
            <?php echo Form::token(); ?>

            <p>Account type: <strong><?php echo $user->role->name; ?></strong></p>

            <?php echo Form::label('email', 'Email Address', array('class' => 'control-label')); ?>
            <?php echo Form::email('email', Input::old('email', Auth::user()->email), array('class' => 'span4')); ?>
            <?php echo Form::label('password', 'Password', array('class' => 'control-label')); ?>
            <?php echo Form::password('password', array('class' => 'span4')); ?>
            <?php echo Form::label('password_confirmation', 'Confirm Password', array('class' => 'control-label')); ?>
            <?php echo Form::password('password_confirmation', array('class' => 'span4')); ?>
            <span class="help-block">Leave the password fields blank to keep your current password.</span>

            <button type="submit" class="btn btn-primary">Save</button>
            <?php echo Form::close(); ?>
        </div>
    </div>

<?php Section::stop(); ?>