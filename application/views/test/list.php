<?php Section::start('content'); ?>

<div class="row">
  <?php if ($user_can_create_more_tests): ?>
    <div class="span3 pull-left">
      <a class="btn btn-info" href="<?php echo URL::to('test/create'); ?>">
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

  <ul class="nav nav-pills test-filter-pills pull-right">
    <li class="<?php if (!$status || $status == 'all') echo 'active'; ?>"><?php echo HTML::link_to_route('test_list_status_filter', 'All Tests', array('all')); ?></li>
    <li class="<?php if ($status == 'passing') echo 'active'; ?>"><?php echo HTML::link_to_route('test_list_status_filter', 'Passing Tests', array('passing')); ?></li>
    <li class="<?php if ($status == 'failing') echo 'active'; ?>"><?php echo HTML::link_to_route('test_list_status_filter', 'Failing Tests', array('failing')); ?></li>
    <li class="<?php if ($status == 'never-run') echo 'active'; ?>"><?php echo HTML::link_to_route('test_list_status_filter', 'Never Run', array('never-run')); ?></li>
  </ul>
</div>

<?php if (count($tests) > 0): ?>
  <?php $sort_icon_class = Input::get('dir', 'asc') == 'asc' ? 'icon-chevron-up' : 'icon-chevron-down'; ?>
  <!--
  <table class="table table-striped table-hover test-list-table">
    <thead>
      <tr>
        <th>
          <?php if (Input::get('sort', 'description') == 'description') printf('<i class="%s"></i>', $sort_icon_class); ?>
          <a href="<?php echo sort_link(URL::to_route('test_list_status_filter', array($status)), 'description', Input::get('sort'), Input::get('dir'), 'description'); ?>">Description</a>
        </th>
        <th>
          <?php if (Input::get('sort') == 'url') printf('<i class="%s"></i>', $sort_icon_class); ?>
          <a href="<?php echo sort_link(URL::to_route('test_list_status_filter', array($status)), 'url', Input::get('sort'), Input::get('dir'), 'description'); ?>">URL</a>
        </th>
        <th>
          <?php if (Input::get('sort') == 'last_run') printf('<i class="%s"></i>', $sort_icon_class); ?>
          <a href="<?php echo sort_link(URL::to_route('test_list_status_filter', array($status)), 'last_run', Input::get('sort'), Input::get('dir'), 'description'); ?>">Last Run</a>
        </th>
        <th></th>
      </tr>
    </thead>
  -->
    <div class="test-list">
        <div class="row">
            <?php $i = 0; foreach ($tests as $test): ?>
                <?php if ($i++ % 3 === 0): ?></div><div class="row"><?php endif; ?>

                <div class="span4 test-list-item test-<?php echo $test->status(); ?> clickable-element" data-link="<?php echo URL::to_route('test_detail', array($test->id)); ?>">
                    <div class="test-list-item-inner">
                        <h4><?php echo $test->description; ?></h4>
                        
                        <div class="last-run">
                        <?php
                            $last_run = $test->last_run_info();
                            printf('<small class="%s">%s %s</small>', $last_run['class'], $last_run['text'], $last_run['time']);
                        ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<?php else: ?>
  <p>No <?php echo (!$status || $status == 'all') ? '' : $status; ?> tests found.</p>
<?php endif; ?>

<?php Section::stop(); ?>

<?php Section::start('additional_footer_content'); ?>
    <script>
    require(["clementia/equal-heights"], function(eqHeight){
        eqHeight.makeEqual('.test-list .row', true);
    });
    </script>
<?php Section::stop(); ?>