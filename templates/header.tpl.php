<!doctype>
<html>
<head>
	<title><?php print page_title();?></title>

	<script language="javascript">
		var ajax_token = "<?php print ajax_token(TRUE);?>";
	</script>

	<?php	if (!empty($config['includes']['css'])):?>
		<?php foreach ($config['includes']['css'] as $css):?>
			<link rel="stylesheet" type="text/css" href="<?php print $css;?>" />
		<?php endforeach;?>
	<?php endif;?>

	<?php	if (!empty($config['includes']['js'])):?>
		<?php foreach ($config['includes']['js'] as $js):?>
			<script language="javascript" type="text/javascript" src="<?php print $js;?>"></script>
		<?php endforeach;?>
	<?php endif;?>

</head>
<body>
