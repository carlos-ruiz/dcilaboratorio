<?php
/* @var $this OrdenesController */
/* @var $model Ordenes */

 if(Yii::app()->user->getState('perfil')=="Administrador") {
 	echo $this->renderPartial('_viewAdministrador',array(
								'model'=>$model,
								'paciente'=>$paciente,
								'pagos'=>$pagos,
								'datosFacturacion'=>$datosFacturacion,
								'examenes'=>$examenes,
								'ordenExamenesModel'=>$ordenExamenesModel,
								'ordenGruposModel'=>$ordenGruposModel,
								'ordenGrupotesModel'=>$ordenGrupotesModel,
								)
					 		);
 }
 if(Yii::app()->user->getState('perfil')=="Doctor") {
 	echo $this->renderPartial('_viewDoctor',array(
								'model'=>$model,
								'paciente'=>$paciente,
								'pagos'=>$pagos,
								'datosFacturacion'=>$datosFacturacion,
								'examenes'=>$examenes,
								'ordenExamenesModel'=>$ordenExamenesModel,
								'ordenGruposModel'=>$ordenGruposModel,
								'ordenGrupotesModel'=>$ordenGrupotesModel,
								)
					 		);
 }
 if(Yii::app()->user->getState('perfil')=="Paciente") {
 	echo $this->renderPartial('_viewPaciente',array(
								'model'=>$model,
								'paciente'=>$paciente,
								'pagos'=>$pagos,
								'datosFacturacion'=>$datosFacturacion,
								'examenes'=>$examenes,
								'ordenExamenesModel'=>$ordenExamenesModel,
								'ordenGruposModel'=>$ordenGruposModel,
								'ordenGrupotesModel'=>$ordenGrupotesModel,
								)
					 		);
 }

?>
