<?php Section::start('content'); ?>
    <div class="row">
        <div class="span6 offset3 login-form">
            <h1>Account</h1>
            <?php echo Form::open('user/index', 'PUT'); ?>
            <?php echo Form::token(); ?>

            <?php if ($pending_downgrade): ?>
                <div class="alert">
                    Your account is pending downgrade to <strong><?php echo $pending_downgrade['role']->name; ?></strong>
                    on <strong><?php echo date('M j, Y', strtotime($pending_downgrade['date'])); ?></strong>.
                    <div>
                        <a href="<?php echo URL::to_route('subscription'); ?>" data-method="DELETE" data-token="<?php echo Session::token(); ?>">Click here to cancel downgrade.</a>
                    </div>
                </div>
            <?php endif; ?>

            <p>Account type: <strong><?php echo $user->role->name; ?></strong></p>

            <p>$<?php echo $user->role->price; ?> per month on your <?php echo $user->card_type; ?> card ending in <?php echo $user->card_last_4; ?></p>

            <?php echo HTML::link_to_route('subscription', 'Change Subscription'); ?>

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