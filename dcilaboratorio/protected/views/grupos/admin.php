<?php
/* @var $this GruposExamenesController */
/* @var $model GruposExamenes */
$this->breadcrumbs=array(
	'Grupos Examenes'=>array('admin'),
	'Administración',
);
?>



<h1>Administrar Grupos Examenes</h1>
<?php 
$this->renderPartial(
	'/comunes/_comunAdmin', 
	array(
		'model'=>$model,
		'titulo'=>'Grupos de exámenes',
		'columnas'=>array(
			'id',
			'nombre'
		)
	)
); 

?>

