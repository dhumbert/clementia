<?php Section::start('content'); ?>

<?php if ($user_can_create_more_tests): ?>
  <p>
    <a class="btn btn-primary" href="<?php echo URL::to('test/create'); ?>">
      <i class="icon-plus icon-white"></i>
      New Test
    </a>
  </p>
<?php else: ?>
  <div class="alert alert-warning">
    You have reached the maximum amount of tests you are allowed. If you'd like to add more, 
    you will need to delete some of the ones below.
  </div>
<?php endif; ?>

<table class="table table-striped">
  <tbody>
    <?php foreach ($tests as $test): ?>
      <tr>
        <td>
          <?php echo $test->description; ?>
        </td>
        <td>
          <a href="<?php echo $test->url; ?>" target="_blank"><?php echo $test->url; ?></a>
          <i class="icon-share"></i>
        </td>
        <td>
          <i class="icon-zoom-in"></i>
          <?php echo HTML::link_to_route('test_detail', 'Details', array($test->id)); ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php Section::stop(); ?>