<?php Section::start('content'); ?>
  
  <h2><?php echo $test->description; ?></h2>

  <p>
    <a href="<?php echo $test->url; ?>" target="_blank"><?php echo $test->url; ?></a>
    <i class="icon-share"></i>    
  </p>

  <p>
    <?php echo HTML::link_to_route('test_run', 'Run Test', array($test->id), array('data-token' => Session::token(), 'data-method' => 'PUT', 'class' => 'btn btn-success')); ?>
  </p>

<?php Section::stop(); ?>