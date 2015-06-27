<?php

class ReportesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $section = "Reportes";
	public $subSection="Generar";
	public $pageTitle="Reportes";
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
			);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
				),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
				),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
				),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','generar'),
				'users'=>array('admin'),
				),
			array('deny',  // deny all users
				'users'=>array('*'),
				),
			);
	}

	
	
	/**
	 * Lists all models.
	 */
	public function actionGenerar()
	{

		$model=new BusquedaForm;


		if(isset($_POST['BusquedaForm']))
		{
			
			$model->attributes=$_POST['BusquedaForm'];
			if(!$model->validate()){
				$this->render('generar', array('model'=>$model));
			}

			$query = Yii::app()->db->createCommand();
			$query->select('ordenes.id');
			$query->from('ordenes');

			if ((isset($model->id_pacientes) && $model->id_pacientes > 0)|| $model->nombre_paciente == 1 || $model->id_paciente == 1)
			{			 
				$query->join('ordenes_facturacion', 'ordenes.id=ordenes_facturacion.id_ordenes');
			}	
			if ((isset($model->clave_examen) && $model->clave_examen > 0)|| $model->id_examen==1) 
			{		
				$query->join('orden_tiene_examenes', 'ordenes.id=orden_tiene_examenes.id_ordenes');
				$query->join('detalles_examen', 'orden_tiene_examenes.id_detalles_examen=detalles_examen.id');
			}

			$query->where('ordenes.fecha_captura>:start and ordenes.fecha_captura<:end', array('start'=>$model->fecha_inicial, 'end'=>$model->fecha_final));
			
			if (isset($model->id_multitarifarios) && $model->id_multitarifarios > 0) {
				$query->andWhere('ordenes.id_multitarifarios=:idMultitarifario', array('idMultitarifario'=>$model->id_multitarifarios));
			}
			if (isset($model->id_doctores) && $model->id_doctores > 0) {				
				$query->andWhere('ordenes.id_doctores=:idDoctor', array('idDoctor'=>$model->id_doctores));
			}
			if (isset($model->id_pacientes) && $model->id_pacientes > 0) {			 	
				$query->andWhere('ordenes_facturacion.id_pacientes=:idPaciente', array('idPaciente'=>$model->id_pacientes));
			}
			if (isset($model->clave_examen) && $model->clave_examen > 0) {			 
				$query->andWhere('detalles_examen.id_examenes=:idExamen', array('idExamen'=>$model->clave_examen));
			}
			
			$resultados=$query->queryAll();
			

			$resultadosMostrar= array();
			if($model->dia==1)
				array_push($resultadosMostrar, 'dia');
			if($model->mes==1)
				array_push($resultadosMostrar, 'mes');
			if($model->año==1)
				array_push($resultadosMostrar, 'año');
			if($model->semana==1)
				array_push($resultadosMostrar, 'semana');
			if($model->hora==1)
				array_push($resultadosMostrar, 'hora');
			if($model->folio==1)
				array_push($resultadosMostrar, 'folio');
			if($model->id_paciente==1)
				array_push($resultadosMostrar, 'id_paciente');
			if($model->nombre_paciente==1)
				array_push($resultadosMostrar, 'nombre_paciente');
			if($model->unidad==1)
				array_push($resultadosMostrar, 'unidad');
			if($model->doctor==1)
				array_push($resultadosMostrar, 'doctor');
			if($model->id_examen==1)
				array_push($resultadosMostrar, 'id_examen');
			if($model->costo==1)
				array_push($resultadosMostrar, 'costo');
			if($model->porcentaje_descuento==1)
				array_push($resultadosMostrar, 'porcentaje_descuento');
			if($model->monto_descuento==1)
				array_push($resultadosMostrar, 'monto_descuento');
			if($model->tarifa==1)
				array_push($resultadosMostrar, 'tarifa');

			$pdf = new ImprimirPdf('P','cm','letter');
			$pdf->model = Ordenes::model()->findByPk(1);
			$pdf->Output();
		//$this->imprimirPdf($resultados, $resultadosMostrar);
		}
		$this->render('generar', array('model'=>$model));
	}

	public function imprimirPdf($resultados, $resultadosMostrar){
		$pdf = new FPDF('P','mm','letter');
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(40,10,'¡Hola mundo? pío');
		$pdf->Output();
	}
	

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->subSection="Admin";
		$model=new TitulosForm('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TitulosForm']))
			$model->attributes=$_GET['TitulosForm'];

		$this->render('admin',array(
			'model'=>$model,
			));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TitulosForm the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TitulosForm::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TitulosForm $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='reportes-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
