<?php
/* @var $this ExamenesController */
/* @var $model Examenes */


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#examenes-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar exámenes</h1>
<?php 
$this->renderPartial(
	'/comunes/_comunAdmin', 
	array(
		'model'=>$model,
		'titulo'=>'Exámenes',
		'columnas'=>array(
			'clave',
			'nombre',
			'descripcion',
			'duracion_dias'
		)
	)
); 

?>
