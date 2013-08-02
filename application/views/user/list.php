<table class="table table-striped">
    <thead>
        <tr>
            <th>Email</th>
            <th>Role</th>
            <th>Sites</th>
            <th>Signed Up</th>
        </tr>
    </thead>
    <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user->email; ?></td>
            <td><?php echo $user->role; ?></td>
            <td><?php echo $user->count_sites(); ?> / <?php echo $user->allowed_sites() ?: "&infin;"; ?></td>
            <td><?php echo $user->signup_date(); ?></td>
        </tr>
    <?php endforeach; ?>
</table>