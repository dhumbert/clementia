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
                            <?php $action = Role::is_upgrade($user->role, $role) ? 'upgrade' : 'downgrade'; ?>
                            <?php if ($user->role_id == $role->id): ?>
                                <a href="javascript:void(0);" class="btn disabled"><i class="icon-ok"></i> Your Current Subscription Level</a>
                            <?php else: ?>
                                <a href="javascript:void(0);" class="btn btn-primary btn-plan-select"
                                   data-price="<?php echo $role->price; ?>"
                                   data-name="<?php echo $role->name; ?>"
                                   data-id="<?php echo $role->id; ?>"
                                    <?php if ($user->is_paying_customer()): ?>
                                       data-toggle="modal"
                                       data-target="#<?php echo $action; ?>Modal"
                                    <?php endif; ?>
                                    ><i class="icon-white icon-ok"></i> Select <?php echo $role->name; ?></a>
                            <?php endif; ?>
                        </li>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="modal hide fade" id="downgradeModal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Downgrade Your Subscription</h3>
            </div>
            <div class="modal-body">
                Your subscription will be downgraded at the end of the current billing cycle.
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn" data-dismiss="modal">Cancel</a>
                <button type="button" class="btn btn-primary" data-form-submit="subscribeForm">Downgrade</button>
            </div>
        </div>

        <div class="modal hide fade" id="upgradeModal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Upgrade Your Subscription</h3>
            </div>
            <div class="modal-body">
                <p>
                    Awesome! Thanks for deciding to upgrade your subscription. Once you click the button below, you will
                    be charged a prorated amount for the rest of the current billing period, and your subscription will
                    be upgraded instantly. You will be charged full price at the beginning of the next period.
                </p>
                <p>
                    We're going to charge your <strong><?php echo $user->card_type; ?></strong> card
                    ending in <strong><?php echo $user->card_last_4; ?></strong>, unless you <a>change that</a>.
                </p>
            </div>
            <div class="modal-footer">
                <a href="javascript:void(0);" class="btn" data-dismiss="modal">Cancel</a>
                <button type="button" class="btn btn-primary" data-form-submit="subscribeForm">Upgrade</button>
            </div>
        </div>
    </form>
<?php Section::stop(); ?>

<?php Section::start('additional_footer_content'); ?>
    <script>
        require([
            'clementia/form-submit',
            'dojo/query',
            'dojo/on',
            'dojo/dom-attr',
            'dojo/domReady!'
        ], function(formSubmit, query, on, domAttr) {
                query('.btn-plan-select').forEach(function(node) {
                    on(node, 'click', function(e){
                        document.getElementById('subscription').value = domAttr.get(node, 'data-id');
                    });
                });
        });
    </script>
    <?php if (!$user->is_paying_customer()): ?>
        <script src="https://checkout.stripe.com/v2/checkout.js"></script>
        <script>
            require(['clementia/stripe-checkout'], function(stripe) {
                stripe('<?php echo $stripe_key; ?>');
            });
        </script>
    <?php endif; ?>
<?php Section::stop(); ?>