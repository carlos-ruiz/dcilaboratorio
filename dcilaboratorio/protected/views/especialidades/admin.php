
<h1>Administrar especialidades</h1>
<div class="text-right">
	<?php echo CHtml::link('<i class="icon-plus"></i> Nueva especialidad', array('especialidades/create'), array('class'=>'btn')); ?>
</div>
<?php 
$this->renderPartial(
	'/comunes/_comunAdmin', 
	array(
		'model'=>$model,
		'titulo'=>'Especialidades',
		'columnas'=>array('nombre')
	)
); 

?>


		
