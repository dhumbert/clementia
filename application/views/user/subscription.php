<?php Section::start('content'); ?>
    <div class="row">
        <h1 class="span7 offset3">Choose Your Subscription Level</h1>
    </div>
    <form method="post" id="subscribeForm">
        <?php echo Form::token(); ?>
        <input type="hidden" name="stripeToken" id="stripeToken">
        <input type="hidden" name="subscription" id="subscription">

        <div class="row subscription-comparison">
            <?php foreach ($roles as $role): ?>
                <div class="subscription span4 subscription-<?php echo strtolower($role->name); ?>">
                    <div class="subscription-header">
                        <h2><?php echo $role->name; ?></h2>
                        <div class="price">
                            $<?php echo $role->price; ?> <span class="per-month"> per month</span>
                        </div>
                    </div>
                    <ul>
                        <li class="sites">
                            <?php echo $role->allowed_sites; ?> site<?php echo intval($role->allowed_sites) > 1 ? 's' : ''; ?>
                        </li>
                        <li class="tests">
                            <?php echo $role->tests_per_site; ?> test<?php echo intval($role->allowed_sites) > 1 ? 's' : ''; ?>
                            per site
                        </li>
                        <li class="select">
                            <?php if ($user->role_id == $role->id): ?>
                                <a href="javascript:void(0);" class="btn disabled"><i class="icon-ok"></i> Your Current Subscription Level</a>
                            <?php else: ?>
                                <a href="javascript:void(0);" data-price="<?php echo $role->price; ?>" data-name="<?php echo $role->name; ?>" data-id="<?php echo $role->id; ?>" class="btn btn-primary btn-plan-select"><i class="icon-white icon-ok"></i> Select <?php echo $role->name; ?></a>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
    </form>
<?php Section::stop(); ?>

<?php Section::start('additional_footer_content'); ?>
    <?php if (!$user->is_paying_customer()): ?>
        <script src="https://checkout.stripe.com/v2/checkout.js"></script>
        <script>
            require(['clementia/stripe-checkout'], function(stripe) {
                stripe('<?php echo $stripe_key; ?>');
            });
        </script>
    <?php endif; ?>
<?php Section::stop(); ?>