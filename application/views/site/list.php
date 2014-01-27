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

    <div class="row bubble-list">
        <?php if (count($sites) > 0): ?>
                <?php foreach ($sites as $site): ?>
                    <div class="span4 bubble-list-item clickable-element" data-link="site/edit/<?php echo $site->id; ?>">
                        <div class="bubble-list-item-inner">
                            <h4><?php echo $site->domain; ?></h4>
                            Used <?php echo count($site->tests); ?> of <?php echo $allowed_tests; ?> tests
                        </div>
                    </div>
                <?php endforeach; ?>

        <?php else: ?>
            <p>No sites found.</p>
        <?php endif; ?>
    </div>

<?php Section::stop(); ?>