<?php
/* @var $this OrdenesController */
/* @var $model Ordenes */

?>

<h1>Update Ordenes <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array(
	'model'=>$model,
 	'paciente'=>$paciente,
 	'datosFacturacion'=>$datosFacturacion,
	'examenes'=>$examenes,
	'pagos'=>$pagos,
	'direccion' => $direccion,
	'listaTarifasExamenes'=>$listaTarifasExamenes,
	'examenesPorGrupo'=>$examenesPorGrupo,
	'ordenTieneGrupos'=>$ordenTieneGrupos,
	)); ?>