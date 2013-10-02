<a href="<?php echo URL::to_route('create_role'); ?>" class="btn btn-info">
    <i class="icon-plus icon-white"></i>
    New Role
</a>

<table class="table table-striped">
    <thead>
    <tr>
        <th>Role</th>
        <th>Allowed Sites</th>
        <th>Tests Per Site</th>
        <th>Monthly Price</th>
        <th></th>
    </tr>
    </thead>

    <?php foreach ($roles as $role): ?>
        <tr>
            <td><?php echo $role->name; ?></td>
            <td><?php echo $role->allowed_sites ?: '&infin;'; ?></td>
            <td><?php echo $role->tests_per_site ?: '&infin;'; ?></td>
            <td>$<?php echo $role->price; ?></td>
            <td>
                <?php echo HTML::link_to_route('edit_role', 'Edit', array($role->id), array('class' => 'btn')); ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>