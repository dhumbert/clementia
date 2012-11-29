<?php Section::start('content'); ?>
<div class="row">
    <div class="span4 offset4 login-form">
        <?php echo Form::open('session/create', 'PUT'); ?>
            <?php echo Form::token(); ?>

            <?php echo render('user.form'); ?>
            <button type="submit" class="btn btn-primary">Log In</button>
        <?php echo Form::close(); ?>
    </div>
</div>
<?php Section::stop(); ?>