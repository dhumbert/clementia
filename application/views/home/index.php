<?php Section::start('content'); ?>
	<div class="row">
		<div class="span6">
			<h2>Lorem Ipsum</h2>
			Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Vivamus vitae risus vitae lorem iaculis placerat. Aliquam sit amet felis. Etiam congue. Donec risus risus, pretium ac, tincidunt eu, tempor eu, quam. Morbi blandit mollis magna. Suspendisse eu tortor. Donec vitae felis nec ligula blandit rhoncus. Ut a pede ac neque mattis facilisis. Nulla nunc ipsum, sodales vitae, hendrerit non, imperdiet ac, ante. Morbi sit amet mi. Ut magna. Curabitur id est. Nulla velit. Sed consectetuer sodales justo. Aliquam dictum gravida libero. Sed eu turpis. Nunc id lorem. Aenean consequat tempor mi. Phasellus in neque. Nunc fermentum convallis ligula.
		</div>
		<div class="span6">
            <h2>Log In</h2>
			<?php echo render('session.login_form'); ?>
		</div>
	</div>

    <div class="row">
        <div class="span12 home-signup">
            <?php echo render('user.signup'); ?>
        </div>
    </div>
<?php Section::stop(); ?>