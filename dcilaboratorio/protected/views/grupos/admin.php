<?php
/* @var $this GruposExamenesController */
/* @var $model GruposExamenes */
?>

<h1>Administrar perfiles / p. perfiles</h1>
<div class="text-right">
	<?php echo CHtml::link('<i class="icon-plus"></i> Nuevo perfil / p. perfil', array('grupos/create'), array('class'=>'btn')); ?>
</div>

<?php 
$this->renderPartial(
	'/comunes/_comunAdmin', 
	array(
		'model'=>$model,
		'titulo'=>'Grupos de ex&aacute;menes',
		'columnas'=>array(
			//'id',
			'nombre'
		)
	)
); 

?>



