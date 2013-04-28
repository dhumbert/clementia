<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>clementia</title>
  <meta name="viewport" content="width=device-width">
  <?php echo Asset::styles(); ?>
  <?php echo Asset::container('header')->scripts(); ?>
</head>
<body>
  <div class="navbar navbar-static-top navbar-inverse">
    <div class="navbar-inner">
      <div class="container">
        <a class="brand" href="<?php echo URL::to_route('home'); ?>">clementia</a>
        <ul class="nav">
        </ul>

        
        <ul class="nav pull-right">
          <?php if (Auth::check()): ?>
            <?php if (Auth::check('Administrator')): ?>
              <li><?php echo HTML::link_to_route('user_list', 'Users'); ?></li>
            <?php endif; ?>

            <li><?php echo HTML::link_to_route('test_list', 'Tests'); ?></li>
            <li><?php echo HTML::link_to_route('user_account', 'Account'); ?></li>
            <li><?php echo HTML::link_to_route('logout', 'Log out', array(), array('data-method' => 'DELETE')); ?></li>
          <?php else: ?>
            <li><?php echo HTML::link_to_route('login', 'Log In'); ?></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>

  <noscript>
    <div class="container">
      <div class="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Oops.</strong> Looks like you have Javascript disabled. Please enable it to use the site. Thanks!
      </div>
    </div>
  </noscript>

  <?php if ($error = Session::get('error')): ?>
    <div class="container" id="flash flash-error">
      <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php if (is_array($error)): ?>
          <ul type="unstyled">
            <?php foreach ($error as $e): ?>
              <li><?php echo $e; ?></li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <?php echo $error; ?>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>

  <?php if ($success = Session::get('success')): ?>
    <div class="container" id="flash flash-success">
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php if (is_array($success)): ?>
          <ul type="unstyled">
            <?php foreach ($success as $s): ?>
              <li><?php echo $s; ?></li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <?php echo $success; ?>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>

  <div class="container" id="content">
    <?php echo Section::yield('content'); ?>
  </div>

  <script>
      var dojoConfig = {
          async: 1,
          baseUrl: "<?php echo URL::to_asset('js/dojo'); ?>",
          packages: [
              { name: "bootstrap", location: "Dojo-Bootstrap" },
              { name: "clementia", location: "clementia" },
              { name: "validatejs", location: "validatejs" },
              { name: "mustache", location: "mustache" },
          ]
      };
  </script>

  <?php echo Asset::container('footer')->scripts(); ?>
  <?php echo Section::yield('additional_footer_content'); ?>
</body>
</html>