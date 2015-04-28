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

<?php if (!empty($regions['header'])):?>
	<?php print $regions['header'];?>
<?php endif;?>

<?php if (!empty($regions['body'])):?>
	<?php print $regions['body'];?>
<?php endif;?>

<?php if (!empty($regions['footer'])):?>
	<?php print $regions['footer'];?>
<?php endif;?>

</body>
</html>