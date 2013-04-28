<?php Section::start('content'); ?>

    <div class="row">
        <?php if ($user_can_create_more_tests): ?>
            <div class="span3 pull-left">
                <a class="btn btn-info" href="<?php echo URL::to('test/create'); ?>">
                <i class="icon-plus icon-white"></i> New Test</a>
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
            <li class="all"><a href="#/all">All Tests</a></li>
            <li class="passing"><a href="#/passing">Passing Tests</a></li>
            <li class="failing"><a href="#/failing">Failing Tests</a></li>
            <li class="never-run"><a href="#/never-run">Never Run</a></li>
        </ul>
    </div>

    <div id="loading">
        <img src="<?php echo URL::to_asset('img/ajax-loader.gif'); ?>" />
    </div>

    <div class="test-list" id="test-list"></div>

<?php Section::stop(); ?>

<?php Section::start('additional_footer_content'); ?>
    <script>
    require(["clementia/test-list"], function(testList){
        testList.build();
    });
    </script>
<?php Section::stop(); ?>