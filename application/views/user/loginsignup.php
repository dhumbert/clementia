<div class="control-group">
  <?php echo Form::label('email', 'E-Mail Address', array('class' => 'control-label')); ?>
  <div class="controls">
    <?php echo Form::text('email', Input::old('email')); ?>
  </div>
</div>

<div class="control-group">
  <?php echo Form::label('password', 'Password', array('class' => 'control-label')); ?>
  <div class="controls">
    <?php echo Form::password('password'); ?>
  </div>
</div>