<?php
$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php

        echo $this->Html->meta('icon');

        echo $this->Html->css('reset');
        echo $this->Html->css('jquery-ui-1.9.1.custom.min', null, array('plugin' => false));
        echo $this->Html->css('tinymce');
        echo $this->Less->less('slashbug');


        echo $this->Html->script('jquery-1.8.2.min.js');
        echo $this->Html->script('jquery-ui-1.9.1.custom.min.js', array('plugin' => false));
        echo $this->Html->script('jquery.validate.min.js');
        echo $this->Html->script('tinymce/tiny_mce.js');
        echo $this->Html->script('main.js');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');


	?>
</head>
<body>
	<div id="container">
		<div id="header">
            <h1><?php echo $title_for_layout ?></h1>
		</div>
		<div id="content">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">

		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
