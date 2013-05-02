<?php Section::start('content'); ?>
    <table class="table table-striped">
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user->email; ?></td>
                <td><?php echo $user->role; ?></td>
                <td><?php echo $user->count_tests(); ?> / <?php echo $user->allowed_tests() ?: "&infin;"; ?></td>
                <td><?php echo $user->signup_date(); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php Section::stop(); ?>