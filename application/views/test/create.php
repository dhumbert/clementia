<?php Section::start('content'); ?>
  <?php echo Form::open(); ?>
    <?php echo Form::token(); ?>

    <?php echo Form::label('description', 'Description'); ?>
    <?php echo Form::text('description'); ?>

    <?php echo Form::label('url', 'URL'); ?>
    <?php echo Form::text('url'); ?>

    <?php echo Form::label('type', 'Test Type'); ?>
    <?php echo Form::select('type', Config::get('tests.types')); ?>

    <?php echo Form::label('options[tag]', 'HTML Tag'); ?>
    <?php echo Form::select('options[tag]', Config::get('tests.tags')); ?>

    <?php echo Form::label('options[text]', 'Element Inner Text'); ?>
    <?php echo Form::text('options[text]'); ?>

    <div class="form-actions">
        <?php echo Form::submit('Save Test', array('class' => 'btn btn-primary')); ?>
    </div>
  
  <?php echo Form::close(); ?>
<?php Section::stop(); ?>