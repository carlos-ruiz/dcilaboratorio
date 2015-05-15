<?php

class GruposController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $section="Examenes";
	public $subSection;
	public $pageTitle="Grupos de Exámenes";
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
		$model=new Grupos;
		$examenes=Examenes::model()->getAll();
		$tiene=array();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Grupos']))
		{
			$tiene=split(',',$_POST['Grupos']['tiene']);
			$model->attributes=$_POST['Grupos'];
			if($model->save()){
				$error=false;
				for($i=0;$i<sizeof($tiene)-1;$i++){
					$grupoExamenes = new GrupoExamenes;
					$grupoExamenes->id_examenes=$tiene[$i];
					$grupoExamenes->id_grupos_examenes = $model->id;
					$grupoExamenes->ultima_edicion = $model->ultima_edicion;
					$grupoExamenes->usuario_ultima_edicion = $model->usuario_ultima_edicion;
					$grupoExamenes->creacion = $model->creacion;
					$grupoExamenes->usuario_creacion = $model->usuario_creacion;
					if(!$grupoExamenes->save())
						$error=true;
				}
				if(!$error)
					$this->redirect(array('admin'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
			'examenes'=>$examenes,
			'tiene'=>$tiene,
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
		$examenes=Examenes::model()->findAll();

		$examenesForGrupo=GrupoExamenes::model()->findExamenesForGrupo($id);
		$tiene=array();
		$i=0;

		foreach ($examenesForGrupo as $examen) {
			$tiene[$i++]=$examen->id;
		}
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Grupos']))
		{

			$tiene=split(',',$_POST['Grupos']['tiene']);
			$model->attributes=$_POST['Grupos'];
			if($model->save()){
				$gruposExamenes=GrupoExamenes::model()->deleteAll('id_grupos_examenes=?',array($id));
				$error=false;
				for($i=0;$i<sizeof($tiene)-1;$i++){
					$grupoExamenes = new GrupoExamenes;
					$grupoExamenes->id_examenes=$tiene[$i];
					$grupoExamenes->id_grupos_examenes = $model->id;
					$grupoExamenes->ultima_edicion = $model->ultima_edicion;
					$grupoExamenes->usuario_ultima_edicion = $model->usuario_ultima_edicion;
					$grupoExamenes->creacion = $model->creacion;
					$grupoExamenes->usuario_creacion = $model->usuario_creacion;
					if(!$grupoExamenes->save())
						$error=true;
				}
				if(!$error)
					$this->redirect(array('admin'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'examenes'=>$examenes,
			'tiene'=>$tiene,
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
		$dataProvider=new CActiveDataProvider('Grupos');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->subSection = "Grupos";
		$model=new Grupos('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Grupos']))
			$model->attributes=$_GET['Grupos'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Grupos the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Grupos::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Grupos $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='grupos-examenes-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
