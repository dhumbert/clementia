<?php Section::start('content'); ?>
    <div class="row">
        <div class="span6 offset3">
            <h2 class="text-center">Forgot Your Password?</h2>
            <p>Enter your email address below. You'll get a link to reset your password.</p>

            <?php echo Form::open(NULL, 'POST'); ?>
                <?php echo Form::token(); ?>

                <?php echo Form::email('email', '', array('class' => 'span6', 'placeholder' => 'Email Address')); ?>

                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="<?php echo URL::to_route('home'); ?>" class="btn">Cancel</a>
            <?php echo Form::close(); ?>
        </div>
    </div>
<?php Section::stop(); ?>