<?php if (isset($mensaje)&&!empty($mensaje)) {
	echo "*************";
	print_r($mensaje);
	?>

	<script type="text/javascript">
		alerta("<?php echo $mensaje ?>","<?php echo $titulo ?>")
	</script>
<?php } ?>