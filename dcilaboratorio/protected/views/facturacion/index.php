<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'grupos-examenes-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
	<?php if(!isset($respuesta)){?>
		<center>
			
				<br><br><br><br>
				<label><font color="BLUE" size="+3"><b>Timbrar XML</b></font></label><br><br>
				<b>Copiar el XML en el siguiente campo: </b><br><br>
				<textarea name="xmlfile" cols="100" rows="20"></textarea><br>
				<input type="reset" value="Borrar">
				<input name="enviar" type="submit" value="Timbrar" /><br><br><br>

			<a href="opensession.html">Abrir sesi&oacute;n</a>&nbsp;|&nbsp;
			<a href="createcfdi.html">Timbrar XML</a>&nbsp;|&nbsp;
			<a href="closesession.html">Cerrar sesi&oacute;n</a>
			<br><br><br><br>
			<b><font color="BLUE" size="-1">4G Factor, S.A. de C.V.</font></b>
		</center>

	<?php }else{?>

			<center>
			<br><br><br><br>
			<label><font color="BLUE" size="+3"><b>XML TIMBRADO</b></font></label><br>
			<textarea name="cfdi" cols="100" rows="20">
 			<?php 
			if ($respuesta['ok'] ){
				printf($cfdi);
				printf('<input type="text" name="nombre" value="'.$respuesta['uuid'].'" />');
			} else{
				printf($respuesta['errorCode']);
			}
			 ?>
			</textarea>
			<br><br><br><br>


 			<?php 
			if ($respuesta['ok']){
				printf('<b>UUID</b><br> <input type="text" size="38" name="nombre" value="'.$uuid.'" readonly=yes />');
				printf('<br><br><a href="javascript:history.back()"> Volver Atrás</a> ');
			} else{
				printf($respuesta['errorCode']);
				printf('<br><br><a href="javascript:history.back()"> Volver Atrás</a> ');
			}
			?>

			<br><br><br><br>

			<b><font color="BLUE" size="-1">4G Factor, S.A. de C.V.</font></b>
		</center>

	<?php } ?>
<?php $this->endWidget(); ?>