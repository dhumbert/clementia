<?php Section::start('content'); ?>

    <h1>Create Site</h1>

    <?php echo Form::open(null, 'POST', array('id' => 'site-form')); ?>
        <?php echo Form::token(); ?>

        <?php echo render('site.form', array('site' => $site, 'domain' => $domain)); ?>

        <div class="form-actions">
            <?php echo Form::submit('Save Site', array('class' => 'btn btn-success')); ?>
        </div>

    <?php echo Form::close(); ?>


<?php Section::stop(); ?>