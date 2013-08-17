<?php Section::start('content'); ?>
    <ul id="admin-tabs" class="nav nav-tabs">
        <li class="active"><a href="javascript:void(0)" data-target="#users">Users</a></li>
        <li><a href="javascript:void(0)" data-target="#roles">Roles</a></li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade in active" id="users">
            <?php echo render('user.list', array('users' => $users)); ?>
        </div>
        <div class="tab-pane fade" id="roles">
            <?php echo render('role.list', array('roles' => $roles)); ?>
        </div>
    </div>
<?php Section::stop(); ?>

<?php Section::start('additional_footer_content'); ?>
    <script>
        require(['bootstrap/Tab', 'dojo/query', 'dojo/router', 'dojo/dom-attr'], function(tab, query, router, domAttr) {
            query('#admin-tabs a').on('click', function(e){
                query(e.target).tab('show');
            });
        });
    </script>
<?php Section::stop(); ?>