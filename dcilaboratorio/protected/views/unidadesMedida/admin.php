<?php
/* @var $this UnidadesMedidaController */
/* @var $model UnidadesMedida */
?>

<h1>Administrar unidades de medidas</h1>
<?php 
$this->renderPartial(
	'/comunes/_comunAdmin', 
	array(
		'model'=>$model,
		'titulo'=>'Unidades de medida',
		'columnas'=>array(
			'nombre',
			'abreviatura',
		)
	)
); 
?>


