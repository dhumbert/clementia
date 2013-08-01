<?php Section::start('content'); ?>

    <div class="row">
        <div class="span3 pull-left">
            <a class="btn btn-info" href="<?php echo URL::to('test/create'); ?>">
            <i class="icon-plus icon-white"></i> New Test</a>
        </div>

        <ul class="nav nav-pills test-filter-pills pull-right">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <span id="active-site">All Sites</span> <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="#/all/all">All Sites</a></li>
                    <?php foreach (Auth::user()->sites as $site): ?>
                        <li><a href="#/<?php echo $site->domain; ?>/all"><?php echo $site->domain; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </li>
            <li class="all"><a id="link-all" href="#/all/all">All Tests</a></li>
            <li class="passing"><a id="link-passing" href="#/all/passing">Passing Tests</a></li>
            <li class="failing"><a id="link-failing" href="#/all/failing">Failing Tests</a></li>
            <li class="never-run"><a id="link-never-run" href="#/all/never-run">Never Run</a></li>
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