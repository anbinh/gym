<html>
<?php echo $this->Html->image('logo_eng.png', array('alt' => 'Gym logo')); ?>
<p>
    Hi, <br/><br/>
    Forgot your Studiogym password? <br/>
    Studiogym received a request to reset the password for your (<?php echo $name?>) account. <br/>
    To reset your password, click on the link below (or copy and paste the URL into your browser): <a href="<?php echo $link?>"><?php echo $link?></a><br/>
    Thank you!
</p>
</html>