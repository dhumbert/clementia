<?php Section::start('content'); ?>

    <h1>Your Sites</h1>

    <?php if (count($sites) > 0): ?>
        <table class="table table-striped">
            <?php foreach ($sites as $site): ?>
                <tr>
                    <td><?php echo $site->domain; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

    <?php else: ?>
        <p>No sites found.</p>
    <?php endif; ?>


<?php Section::stop(); ?>