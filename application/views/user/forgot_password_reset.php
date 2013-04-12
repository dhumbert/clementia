<?php Section::start('content'); ?>
    <div class="row">
        <div class="span6 offset3">
            <h2>Reset Your Password</h2>
            <?php echo Form::open(NULL, 'POST'); ?>
                <?php echo Form::token(); ?>
            <?php echo Form::close(); ?>
        </div>
    </div>
<?php Section::stop(); ?>