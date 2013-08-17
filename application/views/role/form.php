<?php echo Form::token(); ?>

<label for="name">Name</label>
<?php $attrs = $editName ? array() : array('disabled' => 'disabled'); ?>
<?php echo Form::text('name', Input::old('name', $role->name), $attrs); ?>

<label for="allowed_sites">Allowed Sites</label>
<?php echo Form::number('allowed_sites', Input::old('allowed_sites', $role->allowed_sites)); ?>

<label for="tests_per_site">Tests Per Site</label>
<?php echo Form::number('tests_per_site', Input::old('tests_per_site', $role->tests_per_site)); ?>
