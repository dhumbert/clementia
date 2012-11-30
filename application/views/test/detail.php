<?php Section::start('content'); ?>
  
  <h2><?php echo $test->description; ?></h2>

  <div class="well well-large">
  <ul class=" test-description">
    <li>
      Visit <a href="<?php echo $test->url; ?>" target="_blank"><?php echo $test->url; ?></a>
      <i class="icon-share"></i>    
    </li>
    <li>
      <?php echo $description['description']; ?>
      <?php if (count($description['details']) > 0): ?>
        <ul class=" test-description-details">
          <?php foreach ($description['details'] as $detail): ?>
            <li><?php echo $detail; ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </li>
  </ul>
</div>

  <p class="test-detail-actions">
    <a href="<?php echo URL::to_route('test_run', array($test->id)); ?>" data-token="<?php echo Session::token(); ?>" data-method="POST" class="btn btn-success">
      <i class="icon-refresh icon-white"></i> Run Test
    </a>

    <a href="<?php echo URL::to_route('test_edit', array($test->id)); ?>" class="btn btn-info">
      <i class="icon-edit icon-white"></i> Edit Test
    </a>

    <a href="<?php echo URL::to_route('test_delete', array($test->id)); ?>" data-token="<?php echo Session::token(); ?>" data-method="DELETE" class="btn btn-danger">
      <i class="icon-remove icon-white"></i> Delete Test
    </a>
  </p>

  <?php if (count($logs) > 0): ?>
    <table class="table table-striped">
      <?php foreach ($logs as $log): ?>
        <tr class="<?php echo $log->passed ? 'success' : 'error'; ?>">
          <td><?php echo $log->message; ?></td>
          <td><?php echo DateFmt::Format('AGO[t]IF-FAR[M__ d##, y##]', strtotime($log->created_at)); ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php else: ?>
    <p>This test has never been run.</p>
  <?php endif; ?>

<?php Section::stop(); ?>