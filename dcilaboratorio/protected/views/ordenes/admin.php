
<h1>Administrar ordenes</h1>

<?php 
if(Yii::app()->user->getState('perfil')=="Administrador" || Yii::app()->user->getState('perfil')=="Basico") {
	$btnTemplate = '{view} {rate} {updateOrden}';
 }
 if(Yii::app()->user->getState('perfil')=="Doctor") {
 	$btnTemplate = '{view} ';
 }
 if(Yii::app()->user->getState('perfil')=="Paciente") {
 	$btnTemplate = '{view} ';
 }

$this->renderPartial(
	'/comunes/_comunAdmin', 
	array(
		'model'=>$model,
		'titulo'=>'Ordenes',
		'columnas'=>array(
			'folio',
			'status.nombre',
			array(
				'name'=>'Paciente',
				'value'=>array($this, 'obtenerPaciente'),
				),
			'fecha_captura',
		),
		'buttonsTemplate'=> $btnTemplate,
	)
); 

?>


		



