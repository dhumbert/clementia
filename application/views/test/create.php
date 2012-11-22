<?php Section::start('content'); ?>
    
    <h1>Create a Test</h1>

    <?php echo Form::open(); ?>
        <?php echo Form::token(); ?>

    <div class="row">
        <div class="span6">
            <?php echo Form::label('description', 'Description'); ?>
            <?php echo Form::text('description', '', array('class' => 'span6')); ?>
        </div>
        <div class="span6">
            <?php echo Form::label('url', 'URL'); ?>
            <?php echo Form::text('url', '', array('class' => 'span6')); ?>
        </div>
    </div>

    <div class="row">
        <div class="span6">
            <?php echo Form::label('type', 'Test Type'); ?>
            <?php
                $types = Config::get('tests.types');
                if (count($types) > 1) {
                    echo Form::select('type', Config::get('tests.types'), '', array('class' => 'span6'));
                } else {
                    $key = key($types);
                    $type = array_shift($types);
                    echo Form::hidden('type', $key);
                    printf('<em>%s</em>', $type);
                }
            ?>
            <?php  ?>
        </div>
    </div>

    <div class="row">
        <div class="span6">
            <h4>Find the Elements</h4>
            <span class="help-block">
                Choose how to select the element(s). You must select an HTML tag, 
                enter an ID, or both. Once the elements are selected they
                will be filtered according to the other criteria you select.</span>

            <?php echo Form::label('options[tag]', 'HTML Tag'); ?>
            <?php echo Form::select('options[tag]', Config::get('tests.tags')); ?>

            <?php echo Form::label('options[id]', 'ID'); ?>
            <?php echo Form::text('options[id]'); ?>
        </div>
        <div class="span6">
            <h4>Filter the Elements</h4>
            <span class="help-block">
                Choose how to filter the element(s).</span>

            

            <?php echo Form::label('options[text]', 'Element Inner Text'); ?>
            <?php echo Form::text('options[text]'); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php echo Form::submit('Save Test', array('class' => 'btn btn-primary')); ?>
    </div>
  
  <?php echo Form::close(); ?>
<?php Section::stop(); ?>