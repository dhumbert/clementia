<?php echo Form::token(); ?>

<label for="name">Name</label>
<?php echo Form::text('name', Input::old('name', $role->name), array('disabled' => 'disabled')); ?>

<label for="allowed_sites">Allowed Sites</label>
<?php echo Form::text('allowed_sites', Input::old('allowed_sites', $role->allowed_sites)); ?>

<label for="tests_per_site">Tests Per Site</label>
<?php echo Form::text('tests_per_site', Input::old('tests_per_site', $role->tests_per_site)); ?>
