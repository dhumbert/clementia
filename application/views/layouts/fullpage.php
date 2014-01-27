<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>ZafBox</title>
    <meta name="viewport" content="width=device-width">
    <?php echo Asset::styles(); ?>
    <?php echo Asset::container('header')->scripts(); ?>
</head>
<body class="fullpage">

<div class="container brand-container">
    <a href="<?php echo URL::to_route('home'); ?>"><strong>Zaf</strong>Box</a>
    <div class="slogan">Automated testing, decoded.</div>
</div>

<div class="container" id="content">
    <?php echo Section::yield('content'); ?>
</div>

<script>
    var dojoConfig = {
        async: 1,
        baseUrl: "<?php echo URL::to_asset('js/dojo'); ?>",
        packages: [
            { name: "bootstrap", location: "Dojo-Bootstrap" },
            { name: "zafbox", location: "zafbox" },
            { name: "validatejs", location: "validatejs" },
            { name: "mustache", location: "mustache" },
        ]
    };
</script>

<?php echo Asset::container('footer')->scripts(); ?>
<?php echo Section::yield('additional_footer_content'); ?>
</body>
</html>