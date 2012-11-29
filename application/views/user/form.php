<div class="control-group">
  <?php echo Form::label('email', 'Email Address', array('class' => 'control-label')); ?>
  <div class="controls">
    <?php echo Form::text('email', Input::old('email'), array('class' => 'span4')); ?>
  </div>
</div>

<div class="control-group">
  <?php echo Form::label('password', 'Password', array('class' => 'control-label')); ?>
  <div class="controls">
    <?php echo Form::password('password', array('class' => 'span4')); ?>
  </div>
</div>