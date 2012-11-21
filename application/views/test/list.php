<?php Section::start('content'); ?>

<?php echo HTML::link('test/create', 'New Test'); ?>

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