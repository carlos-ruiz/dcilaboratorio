<?php
/* @var $this PalabrasClaveController */
/* @var $model PalabrasClave */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#palabras-clave-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar palabras clave</h1>
<?php 
$this->renderPartial(
	'/comunes/_comunAdmin', 
	array(
		'model'=>$model,
		'titulo'=>'Palabras clave',
		'columnas'=>array(
			'nombre'
		)
	)
); 
?>

