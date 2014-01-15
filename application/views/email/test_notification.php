<?php
$summary_style = "padding: 0.5em 1em;border-radius: 1em;text-align: center;float: left;";
if ($statistics['pass_rate'] == 100) {
    $summary_style .= "color: #468847;background-color: #dff0d8;border: 1px solid #d6e9c6;";
} elseif ($statistics['pass_rate'] >= 75) {
    $summary_style .= "color: #c09853;background-color: #fcf8e3;border: 1px solid #fbeed5;";
} else {
    $summary_style .= "color: #b94a48;background-color: #f2dede;border: 1px solid #eed3d7;";
}
?>

<h1>ZafBox Test Run</h1>

<p>Below is a summary of the most recent run of your scheduled tests.</p>

<div style="margin-bottom: 2em;">
    <div style="<?php echo $summary_style; ?>">
        <div style="font-size: 3em;font-weight:bold;"><?php echo $statistics['pass_rate']; ?>%</div>
        <div>Pass Rate</div>
    </div>

    <div style="float: left;width: 10em;font-size: 2em;color: #aaa;padding-top: 0.75em;padding-left: 1em;">
        <span style="color: #468847;"><?php echo $statistics['passing']; ?> passed</span> 
        &amp; 
        <span style="color: #b94a48;"><?php echo $statistics['failing']; ?> failed</span>.
    </div>
    <div style="clear:both;"></div>
</div>

<?php foreach(array_keys($tests) as $status): ?>
    <?php if (count($tests[$status]) > 0): ?>
        <h2><?php echo ucwords($status); ?> Tests</h2>
        <ul style="padding-left: 0;list-style-type: square;margin-left: 0;">
            <?php foreach ($tests[$status] as $test): ?>
                <li style="margin-bottom: 0.5em;"><?php echo HTML::link_to_route('test_detail', $test->description, array($test->id)); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
<?php endforeach; ?>