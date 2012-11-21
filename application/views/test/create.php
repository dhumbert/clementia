<?php Section::start('content'); ?>
  <?php echo Form::open(); ?>
    <?php echo Form::token(); ?>

    <?php echo Form::label('description', 'Description'); ?>
    <?php echo Form::text('description'); ?>

    <?php echo Form::label('url', 'URL'); ?>
    <?php echo Form::text('url'); ?>

    <?php echo Form::label('type', 'Test Type'); ?>
    <?php echo Form::select('type', Config::get('tests.types')); ?>

    <?php echo Form::label('options[element]', 'HTML Element'); ?>
    <?php echo Form::select('options[element]', Config::get('tests.elements')); ?>

    <?php echo Form::label('options[text]', 'Element Inner Text'); ?>
    <?php echo Form::text('options[text]'); ?>

    <?php echo Form::submit('Save Test', array('class' => 'btn btn-primary')); ?>
  
  <?php echo Form::close(); ?>
<?php Section::stop(); ?>