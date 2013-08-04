<?php Section::start('content'); ?>
    <ul id="admin-tabs" class="nav nav-tabs">
        <li class="active"><a href="#users" data-toggle="tab">Users</a></li>
        <li><a href="#roles" data-toggle="tab">Roles</a></li>
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
        require(['bootstrap/Tab']);
    </script>
<?php Section::stop(); ?>