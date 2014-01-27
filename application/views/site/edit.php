<?php Section::start('content'); ?>

    <h1>Edit Site</h1>

    <?php echo Form::open(null, 'POST', array('id' => 'site-form')); ?>
        <?php echo Form::token(); ?>

        <?php echo render('site.form', array('site' => $site, 'domain' => $domain)); ?>

        <div class="form-actions">
            <?php echo Form::submit('Save Site', array('class' => 'btn btn-success')); ?>
            <?php echo HTML::link('site/delete/'.$site->id, 'Delete Site', array('class' => 'btn btn-danger', 'data-method' => 'DELETE', 'data-confirm' => 'Are you sure you to delete this site? This will also delete all tests associated with the site.')); ?>
        </div>

    <?php echo Form::close(); ?>


<?php Section::stop(); ?>