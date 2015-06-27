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
		$this->subSection = "Nuevo";
		$model=new TitulosForm;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TitulosForm']))
		{
			$model->attributes=$_POST['TitulosForm'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['TitulosForm']))
		{
			$model->attributes=$_POST['TitulosForm'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
	public function actionGenerar()
	{
		$model=new BusquedaForm;
		$criteria=new CDbCriteria;

		if(isset($_POST['BusquedaForm']))
		{
			$model->attributes=$_POST['BusquedaForm'];
			$query = Yii::app()->db->createCommand();
			$query->select('*');
			$query->from('ordenes');
			$query->where('ordenes.fecha_captura>:start and ordenes.fecha_captura<:end', array('start'=>$model->fecha_inicial, 'end'=>$model->fecha_final));
			if (isset($model->id_multitarifarios) && $model->id_multitarifarios > 0) {
				$query->join('multitarifarios', 'ordenes.id_multitarifarios=multitarifarios.id');
				$query->andWhere('multitarifarios.id=:idMultitarifario', array('idMultitarifario'=>$model->id_multitarifarios));
			}
			if (isset($model->id_doctores) && $model->id_doctores > 0) {
				$query->join('doctores', 'ordenes.id_doctores=doctores.id');
				$query->andWhere('doctores.id=:idDoctor', array('idDoctor'=>$model->id_doctores));
			}
			// if (isset($model->id_doctores) && $model->id_doctores > 0) {
			// 	$query->join('doctores', 'ordenes.id_doctores=doctores.id');
			// 	$query->andWhere('doctores.id=:idDoctor', array('idDoctor'=>$model->id_doctores));
			// }
			// if (isset($model->id_doctores) && $model->id_doctores > 0) {
			// 	$query->join('doctores', 'ordenes.id_doctores=doctores.id');
			// 	$query->andWhere('doctores.id=:idDoctor', array('idDoctor'=>$model->id_doctores));
			// }
			// if (isset($model->id_doctores) && $model->id_doctores > 0) {
			// 	$query->join('doctores', 'ordenes.id_doctores=doctores.id');
			// 	$query->andWhere('doctores.id=:idDoctor', array('idDoctor'=>$model->id_doctores));
			// }
			$result=$query->queryAll();
			print_r($result);
			return;
			

			//$models=Ordenes::model()->findAll();
			
			
			//$criteria->join = 'orden_precio_examen';
			$criteria->condition = 'id_doctores = :idDoctores';
        	$criteria->params = array(":idDoctores" => $model['id_doctores'], 
        							  ":id_multitarifarios"=> $model['id_multitarifarios'],
        							  );
			$criteria->addBetweenCondition('creacion', $model['fecha_inicial'], $model['fecha_final']);
			


			/*$models=Ordenes::model()->findAllByAttributes(array(
			'id_doctores'=>$model['id_doctores'],
			'id_multitarifarios'=>$model['id_multitarifario'],			
			),$criteria);
			print_r($models);*/




			
			//$resultado = $model->search();
			
		}
		$this->render('generar', array('model'=>$model));
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