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
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container">
        <a class="brand" href="<?php echo URL::to_route('home'); ?>">clementia</a>
        <ul class="nav">
        </ul>

        
        <ul class="nav pull-right">
          <?php if (Auth::check()): ?>
            <li><?php echo HTML::link('test', 'Tests'); ?></li>
            <li><?php echo HTML::link_to_route('user_account', 'Account'); ?></li>
            <li><?php echo HTML::link_to_route('logout', 'Log out', array(), array('data-method' => 'DELETE')); ?></li>
          <?php else: ?>
            <li><?php echo HTML::link_to_route('login', 'Log In'); ?></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>

  <?php if ($error = Session::get('error')): ?>
    <div class="container" id="flash flash-error">
      <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">×</button>
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
        <button type="button" class="close" data-dismiss="alert">×</button>
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
              { name: "clementia", location: "clementia" }
          ]
      };
  </script>

  <?php echo Asset::container('footer')->scripts(); ?>
  <?php echo Section::yield('additional_footer_content'); ?>
</body>
</html>