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
	 * Generar reporte en PDF
	 */
	public function actionGenerar()
	{

		$model=new BusquedaForm;
		$resultados = array();
		$resultadosMostrar = array();

		if(isset($_POST['BusquedaForm']))
		{

			$model->attributes=$_POST['BusquedaForm'];
			if(!$model->validate()){
				$this->render('generar', array('model'=>$model));
			}
			$final_date = date('Y-m-d', strtotime( "$model->fecha_final + 1 day" ));
			$model->fecha_final = $final_date;

			$query = Yii::app()->db->createCommand();
			//$query->select('ordenes.id');
			$query->selectDistinct('ordenes.id');
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
			$mostrarTodos = (
				$model->dia==0 &&
				$model->mes==0 &&
				$model->año==0 &&
				$model->semana==0 &&
				$model->hora==0 &&
				$model->folio==0 &&
				$model->id_paciente==0 &&
				$model->nombre_paciente==0 &&
				$model->unidad==0 &&
				$model->doctor==0 &&
				$model->id_examen==0 &&
				$model->costo==0 &&
				$model->porcentaje_descuento==0 &&
				$model->monto_descuento==0 &&
				$model->tarifa==0
			);

			$resultadosMostrar = array();
			if($model->dia==1 || $mostrarTodos==1)
				array_push($resultadosMostrar, array('nombre'=>utf8_encode('Día'), 'id'=>'day'));
			if($model->mes==1 || $mostrarTodos==1)
				array_push($resultadosMostrar, array('nombre'=>'Mes', 'id'=>'month'));
			if($model->año==1 || $mostrarTodos==1)
				array_push($resultadosMostrar, array('nombre'=>utf8_encode('Año'), 'id'=>'year'));
			if($model->semana==1 || $mostrarTodos==1)
				array_push($resultadosMostrar, array('nombre'=>'Sem', 'id'=>'week'));
			if($model->hora==1 || $mostrarTodos==1)
				array_push($resultadosMostrar, array('nombre'=>'Hora', 'id'=>'hr'));
			if($model->folio==1 || $mostrarTodos==1)
				array_push($resultadosMostrar, array('nombre'=>'Folio', 'id'=>'folio'));
			if($model->id_paciente==1 || $mostrarTodos==1)
				array_push($resultadosMostrar, array('nombre'=>'Id P', 'id'=>'idp'));
			if($model->nombre_paciente==1 || $mostrarTodos==1)
				array_push($resultadosMostrar, array('nombre'=>'Paciente', 'id'=>'namep'));
			if($model->unidad==1 || $mostrarTodos==1)
				array_push($resultadosMostrar, array('nombre'=>'UR', 'id'=>'ur'));
			if($model->doctor==1 || $mostrarTodos==1)
				array_push($resultadosMostrar, array('nombre'=>'Doctor', 'id'=>'dr'));
			if($model->id_examen==1 || $mostrarTodos==1)
				array_push($resultadosMostrar, array('nombre'=>'Examen', 'id'=>'exam'));
			if($model->costo==1 || $mostrarTodos==1)
				array_push($resultadosMostrar, array('nombre'=>'Costo', 'id'=>'cost'));
			if($model->porcentaje_descuento==1 || $mostrarTodos==1)
				array_push($resultadosMostrar, array('nombre'=>'% Desc', 'id'=>'discp'));
			if($model->monto_descuento==1 || $mostrarTodos==1)
				array_push($resultadosMostrar, array('nombre'=>'$ Desc', 'id'=>'disa'));
			if($model->tarifa==1 || $mostrarTodos==1)
				array_push($resultadosMostrar, array('nombre'=>'Tarifa', 'id'=>'tarifa'));

			echo "<br/>Resultados:<br/>";
			print_r($resultados);
			echo "<br/><br/>Resultados Mostrar:<br/>";
			print_r($resultadosMostrar);
			// return;
			// $pdf = new ImprimirPdf('L','cm','letter');
			// $pdf->AddPage();
			// $pdf->cabeceraHorizontal($resultadosMostrar);
			// $pdf->contenido($resultados, $resultadosMostrar);
			// $pdf->Output();
		}
		$this->render('generar', array(
			'model'=>$model,
			'resultados'=>$resultados,
			'resultadosMostrar'=>$resultadosMostrar,
			));
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
			throw new CHttpException(404,'La página solicitada no existe.');
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
