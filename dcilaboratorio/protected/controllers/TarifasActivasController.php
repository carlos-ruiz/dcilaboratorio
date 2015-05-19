<?php

class TarifasActivasController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $pageTitle = 'Tarifas activas';
	public $section = "Examenes";
	public $subSection;
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new TarifasActivas;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TarifasActivas']))
		{
			$model->attributes=$_POST['TarifasActivas'];

			if($model->FindByAttributes(array('id_examenes'=>$model->id_examenes, 'id_multitarifarios'=>$model->id_multitarifarios)))
				echo "<script>alert('Tarifa activa registrada para ese examen y multitarifario ');</script>";	

			else{
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TarifasActivas']))
		{
			$model->attributes=$_POST['TarifasActivas'];
if($model->FindByAttributes(array('id_examenes'=>$model->id_examenes, 'id_multitarifarios'=>$model->id_multitarifarios)))
				echo "<script>alert('Tarifa activa registrada para ese examen y multitarifario ');</script>";	

			else{
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
}
		}

		$this->render('update',array(
			'model'=>$model,
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
		$dataProvider=new CActiveDataProvider('TarifasActivas');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->subSection = "Tarifas";
		$model=new TarifasActivas('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TarifasActivas']))
			$model->attributes=$_GET['TarifasActivas'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return TarifasActivas the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=TarifasActivas::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param TarifasActivas $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tarifas-activas-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function obtenerNombreExamen($data, $row){
		$examen = Examenes::model()->find($data->id_examenes);
		return $examen->nombre;
	} 

	public function obtenerNombreMultitarifario($data, $row){
		$multitarifario = Multitarifarios::model()->find($data->id_multitarifarios);
		return $multitarifario->nombre;
	}

	public function obtenerPrecioConFormato($data, $row){
		return Yii::app()->numberFormatter->formatCurrency($data->precio, 'MXN');
	}
}