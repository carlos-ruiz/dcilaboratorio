<p>Message from <?php echo $name . ': ' . $message ?></p>
<p>Password: <?php echo $pass; ?></p>
<p>You may change the content of this page by modifying the following two files:</p>
<ul>
	<li>View file: <tt><?php echo __FILE__; ?></tt></li>
	<li>Layout file: <tt><?php echo $this->getLayoutFile('mail'); ?></tt></li>
</ul>