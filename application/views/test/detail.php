<?php Section::start('content'); ?>
  
  <h2><?php echo $test->description; ?></h2>

  <?php if ($test->is_queued()): ?>
    <div class="alert alert-info">
      This test is scheduled to be run soon&hellip;
    </div>
  <?php endif; ?>

  <div class="well well-large">
  <ul class=" test-description">
    <li>
      Visit <a href="<?php echo $test->full_url(); ?>" target="_blank"><?php echo $test->full_url(); ?></a>
      <i class="icon-share"></i>    
    </li>
    <li>
      <?php echo $description['description']; ?>
      <?php if (count($description['details']) > 0): ?>
        <ul class="test-description-details">
          <?php foreach ($description['details'] as $detail): ?>
            <li><?php echo $detail; ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
    </li>
    <li>
      <?php if ($test->autorun): ?>
        Run automatically
      <?php else: ?>
        Run manually
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

    <a href="<?php echo URL::to_route('test_delete', array($test->id)); ?>" data-token="<?php echo Session::token(); ?>" data-method="DELETE" class="btn btn-danger" data-confirm="Are you sure you to delete this site? This action is irreversible.">
      <i class="icon-remove icon-white"></i> Delete Test
    </a>
  </p>

  <?php if (count($logs) > 0): ?>
    <table class="table table-striped">
      <?php foreach ($logs as $log): ?>
        <tr>
          <td>
            <i class="<?php echo $log->passed ? 'icon-ok' : 'icon-remove'; ?>"></i>
            <span class="success"><?php echo $log->message; ?></span>
          </td>
          <td><?php echo DateFmt::Format('AGO[t]IF-FAR[M__ d##, y##]', strtotime($log->created_at)); ?></td>
          <td>
              <?php if ($log->screenshot): ?>
                  <i class="icon-camera"></i>
                  <a href="<?php echo URL::to_asset('user/screenshots/' . $log->screenshot); ?>">
                      Screenshot
                  </a>
              <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php else: ?>
    <p>This test has never been run.</p>
  <?php endif; ?>

<?php Section::stop(); ?>