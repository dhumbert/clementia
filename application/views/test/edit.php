<?php Section::start('content'); ?>
    
    <h1>Edit Test</h1>

    <?php echo Form::open(); ?>
        <?php echo Form::token(); ?>

    <?php echo render('test.form', array('test' => $test)); ?>

    <div class="form-actions">
        <?php echo Form::submit('Save Test', array('class' => 'btn btn-primary')); ?>
    </div>
  
  <?php echo Form::close(); ?>
<?php Section::stop(); ?>