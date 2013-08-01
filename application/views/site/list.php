<?php Section::start('content'); ?>

    <div class="row top-row">
        <?php if ($user_can_create_more_sites): ?>
            <div class="span3 pull-left">
                <a class="btn btn-info" href="<?php echo URL::to('site/create'); ?>">
                    <i class="icon-plus icon-white"></i> New Site</a>
            </div>
        <?php else: ?>
            <div class="span12">
                <div class="alert alert-warning">
                    You have reached the maximum amount of sites you are allowed. If you'd like to add more,
                    you will need to delete some of the ones below, or upgrade. <!-- todo: upgrade link -->
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="row">
        <div class="span12">
            <?php if (count($sites) > 0): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Domain</th>
                            <th>Tests</th>
                            <th></th>
                        </tr>
                    </thead>
                    <?php foreach ($sites as $site): ?>
                        <tr>
                            <td><?php echo $site->domain; ?></td>
                            <td>
                                <?php echo count($site->tests); ?>
                                / <?php echo $allowed_tests; ?>
                            </td>
                            <td>
                                <?php echo HTML::link('site/delete/'.$site->id, 'Delete', array('class' => 'btn btn-danger', 'data-method' => 'DELETE')); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>

            <?php else: ?>
                <p>No sites found.</p>
            <?php endif; ?>
        </div>
    </div>


<?php Section::stop(); ?>