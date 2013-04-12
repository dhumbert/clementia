<?php $url = URL::to_route('user_forgot_password_reset', array($token)); ?>

<p>
    Hi! We received a password reset request for your account at Clementia. If you didn't initiate
    this request, you can safely ignore this email. To reset your password, please click the link below:
</p>

<p>
    <a href="<?php echo $url; ?>"><?php echo $url; ?></a>
</p>