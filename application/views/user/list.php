<?php Section::start('content'); ?>
    <table class="table table-striped">
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user->email; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php Section::stop(); ?>