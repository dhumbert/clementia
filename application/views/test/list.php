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
          <?php echo HTML::link_to_route('test_detail', $test->description, array($test->id)); ?>
        </td>
        <td>
          <a href="<?php echo $test->url; ?>" target="_blank"><?php echo $test->url; ?></a>
          <i class="icon-share"></i>
        </td>
        <td>
          <?php 
          $last_run = $test->last_run();
          if ($last_run) {
            $time = DateFmt::Format('AGO[t]IF-FAR[M__ d##, y##]', strtotime($last_run->created_at)); 
            $class = $last_run->passed ? 'text-success' : 'text-error';
            printf('<small class="%s">%s</small>', $class, $time);
          } else {
            echo '<small class="muted">Never run</small>';
          }
          ?>
        </td>
        <td>
          <a href="<?php echo URL::to_route('test_detail', array($test->id)); ?>"><i class="icon-zoom-in"></i></a>
          <a data-method="DELETE" href="<?php echo URL::to_route('test_delete', array($test->id)); ?>"><i class="icon-remove"></i></a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php Section::stop(); ?>