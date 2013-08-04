<?php Section::start('content'); ?>
    <h1>Edit Role</h1>
    <form action="" method="post">
        <?php echo render('role.form', array('role' => $role)); ?>
        <div class="form-actions">
            <?php echo Form::submit('Save Role', array('class' => 'btn btn-primary')); ?>
        </div>
    </form>
<?php Section::stop(); ?>