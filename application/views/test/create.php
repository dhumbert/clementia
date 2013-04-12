<?php Section::start('content'); ?>
    
    <h1>Create a Test</h1>

    <?php echo Form::open(); ?>
        <?php echo Form::token(); ?>

    <?php echo render('test.form', array('test' => $test, 'types' => $types)); ?>

    <div class="form-actions">
        <?php echo Form::submit('Save Test', array('class' => 'btn btn-primary')); ?>
    </div>
  
  <?php echo Form::close(); ?>
<?php Section::stop(); ?>