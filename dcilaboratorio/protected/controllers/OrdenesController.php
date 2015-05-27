<?php

class OrdenesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $section = "Ordenes";
	public $subSection;
	public $pageTitle="Ordenes";

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
				'actions'=>array('create','update','loadModalContent'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$pagos=new Pagos('search');
		$datosFacturacion=new DatosFacturacion('search');
		$paciente =new Pacientes;
		$examenes=new Examenes('search');
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'paciente'=>$paciente,
			'pagos'=>$pagos,
			'datosFacturacion'=>$datosFacturacion,
			'examenes'=>$examenes,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$this->subSection = "Nuevo";
		$model=new Ordenes;
		$paciente =new Pacientes;
		$datosFacturacion=new DatosFacturacion;
		$examenes=new Examenes;
		$pagos=new Pagos;
		$direccion = new Direcciones;
		

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ordenes']))
		{
			$model->attributes=$_POST['Ordenes'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
			'paciente'=>$paciente,
			'datosFacturacion'=>$datosFacturacion,
			'examenes'=>$examenes,
			'pagos'=>$pagos,
			'direccion' => $direccion,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$paciente =new Pacientes;
		$datosFacturacion=new DatosFacturacion;
		$examenes=new Examenes;
		$pagos=new Pagos;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ordenes']))
		{
			$model->attributes=$_POST['Ordenes'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
			'paciente'=>$paciente,
			'datosFacturacion'=>$datosFacturacion,
			'examenes'=>$examenes,
			'pagos'=>$pagos,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model=$this->loadModel($id);
		if(isset($model->activo))
			$model->activo=$model->activo==0?1:0;
		else
			$model->delete();
		$model->save();	

		$status = (!isset($model->activo)?"Eliminado":($model->activo==0?"Desactivado":"Activado"));
		echo '{id:'.$model->id.', estatus:'.$status.'}';
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Ordenes');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$paciente =new Pacientes('search');;
		$this->subSection = "Admin";
		$model=new Ordenes('search');
		
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Ordenes']))
			$model->attributes=$_GET['Ordenes'];

		$this->render('admin',array(
			'model'=>$model,
			'paciente'=>$paciente,

		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Ordenes the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Ordenes::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Ordenes $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ordenes-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	*Modal 
	*/

	public function actionLoadModalContent(){
		$pagos=new Pagos;
		$form=$this->beginWidget('CActiveForm', array(
		'id'=>'pagos-form',
		// Please note: When you enable ajax validation, make sure the corresponding
		// controller action is handling ajax validation correctly.
		// There is a call to performAjaxValidation() commented in generated controller code.
		// See class documentation of CActiveForm for details on this.
		'enableAjaxValidation'=>false,
	)); 
		$this->renderPartial("_modalPagos",
			array('pagos'=>$pagos,'form'=>$form)
			);
		$this->endWidget();
	}





	public function obtenerPaciente($data, $row){
		$paciente =Pacientes::model()->findByAttributes(array('id'=>$data['id_pacientes']));
		$completo =$paciente->nombre.' '.$paciente->a_paterno.' '.$paciente->a_materno;
		return $completo;
	}

	public function obtenerNombreCompletoDoctor($data, $row){		
		$doctor =Doctores::model()->findByAttributes(array('id'=>$data['id_doctores']));
		$titulo = TitulosForm::model()->findByPk($doctor->id_titulos);
		$completo = $titulo->nombre.' '.$doctor->nombre.' '.$doctor->a_paterno.' '.$doctor->a_materno;
		return $completo;
	}

	public function obtenerSioNoComparteDr($data, $row){		
		if ($data['requiere_factura'] = 0)
			$var = "Sí";
		else
			$var = "No";
		return $var;
	}

	public function obtenerGenero($data, $row){		
		$paciente =Pacientes::model()->findByAttributes(array('id'=>$data['id_pacientes']));
		if ($paciente['sexo'] = 1)
			$var = "Mujer";
		else
			$var = "Hombre";
		return $var;
	}

	public function obtenerNombreNombreFactura($data, $row){		
		$doctor =DatosFacturacion::model()->findByAttributes(array('id'=>$data['id_pacientes']));
		$completo = $doctor->nombre.' '.$doctor->a_paterno.' '.$doctor->a_materno;
		return $completo;
	}

	public function obtenerExamenes($data, $row){		
		$examen =OrdenTieneExamenes::model()->findByAttributes(array('id_ordenes'=>$data['id']));
		$exam = $examen->nombre;
		return $exam;
	}

	public function obtenerPagos($data, $row){		
		$pagos =Pagos::model()->findByAttributes(array('id_ordenes'=>$data['id']));
		return $pagos;
	}
	

}
