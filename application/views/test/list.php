<?php Section::start('content'); ?>

<div class="row">
  <?php if ($user_can_create_more_tests): ?>
    <div class="span3 pull-left">
      <a class="btn btn-primary" href="<?php echo URL::to('test/create'); ?>">
        <i class="icon-plus icon-white"></i>
        New Test
      </a>
    </div>
  <?php else: ?>
    <div class="span12">
      <div class="alert alert-warning">
        You have reached the maximum amount of tests you are allowed. If you'd like to add more, 
        you will need to delete some of the ones below.
      </div>
    </div>
  <?php endif; ?>

  <ul class="nav nav-pills span4 pull-right">
    <li class="<?php if (!$status || $status == 'all') echo 'active'; ?>"><?php echo HTML::link_to_route('test_list_status_filter', 'All Tests', array('all')); ?></li>
    <li class="<?php if ($status == 'passing') echo 'active'; ?>"><?php echo HTML::link_to_route('test_list_status_filter', 'Passing Tests', array('passing')); ?></li>
    <li class="<?php if ($status == 'failing') echo 'active'; ?>"><?php echo HTML::link_to_route('test_list_status_filter', 'Failing Tests', array('failing')); ?></li>
  </ul>
</div>

<?php if (count($tests) > 0): ?>
  <?php $sort_icon_class = Input::get('dir', 'asc') == 'asc' ? 'icon-chevron-up' : 'icon-chevron-down'; ?>
  <table class="table table-striped">
    <thead>
      <tr>
        <th>
          <?php if (Input::get('sort', 'description') == 'description') printf('<i class="%s"></i>', $sort_icon_class); ?>
          <a href="<?php echo sort_link(URL::to_route('test_list_status_filter', array($status)), 'description', Input::get('sort'), Input::get('dir')); ?>">Description</a>
        </th>
        <th>
          <?php if (Input::get('sort') == 'url') printf('<i class="%s"></i>', $sort_icon_class); ?>
          <a href="<?php echo sort_link(URL::to_route('test_list_status_filter', array($status)), 'url', Input::get('sort'), Input::get('dir')); ?>">URL</a>
        </th>
        <th>
          <?php if (Input::get('sort') == 'last_run') printf('<i class="%s"></i>', $sort_icon_class); ?>
          <a href="<?php echo sort_link(URL::to_route('test_list_status_filter', array($status)), 'last_run', Input::get('sort'), Input::get('dir')); ?>">Last Run</a>
        </th>
        <th></th>
      </tr>
    </thead>
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
            $last_run = $test->last_run;
            if ($last_run) {
              $time = DateFmt::Format('AGO[t]IF-FAR[M__ d##, y##]', strtotime($last_run)); 
              $class = $test->passing ? 'text-success' : 'text-error';
              printf('<small class="%s">%s</small>', $class, $time);
            } else {
              echo '<small class="muted">Never run</small>';
            }
            ?>
          </td>
          <td>
            <a title="Delete this test" data-method="DELETE" href="<?php echo URL::to_route('test_delete', array($test->id)); ?>"><i class="icon-remove"></i></a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

<?php else: ?>
  <p>No <?php echo (!$status || $status == 'all') ? '' : $status; ?> tests found.</p>
<?php endif; ?>

<?php Section::stop(); ?>