<?php Section::start('content'); ?>
    <div class="row">
        <div class="span6 offset3">
            <h2>Reset Your Password</h2>
            <?php echo Form::open(NULL, 'POST'); ?>
                <?php echo Form::token(); ?>

                <?php echo Form::password('password', array('class' => 'span6', 'placeholder' => 'Enter a new password')); ?>
                <?php echo Form::password('password_confirmation', array('class' => 'span6', 'placeholder' => 'Confirm your new password')); ?>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>

            <?php echo Form::close(); ?>
        </div>
    </div>
<?php Section::stop(); ?>