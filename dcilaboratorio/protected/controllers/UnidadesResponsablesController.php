<?php

class UnidadesResponsablesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $section = "UnidadesResponsables";
	public $subSection;
	public $pageTitle="Unidades Responsables";
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
				'actions'=>array('create','update', 'municipiosPorEstado'),
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
		$this->subSection = "Nuevo";
		$model = new UnidadesResponsables;
		$direccion = new Direcciones;
		$contacto = new Contactos;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$transaction = Yii::app()->db->beginTransaction();
		try
		{
			if(isset($_POST['UnidadesResponsables']))
			{
				$model->attributes=$_POST['UnidadesResponsables'];

				if(isset($_POST['Direcciones'])){
					$direccion->attributes = $_POST['Direcciones'];
					$direccion->save();
				}

				$model->id_direccion=$direccion->id;

				if($model->save()){
					if(isset($_POST['Contactos'])){
						$contacto->attributes = $_POST['Contactos'];
						$contacto->id_persona = $model->id;
						$tipo = TiposContacto::model()->findByName('Celular');
						$contacto->id_tipos_contacto = $tipo['id'];
						if($perfil = Perfiles::model()->findByName("Unidad responsable")){			
							$contacto->id_perfiles=$perfil->id;
						}
						else{
							$perfil = new Perfiles;
							$perfil->nombre="Unidad responsable";
							$perfil->save();
							$contacto->id_perfiles=$perfil->id;	
						}
						$contacto->save();
					}
					$transaction->commit();
					$this->redirect(array('view','id'=>$model->id));
				}
				else{
					$transaction->rollback();
				}
			}
		}catch(Exception  $ex){
			print_r($ex);
			$transaction->rollback();
		}

		$this->render('create',array(
			'model' => $model,
			'direccion' => $direccion,
			'contacto' => $contacto,
			)
		);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$perfil = Perfiles::model()->findByName("Unidad responsable");
		$model=$this->loadModel($id);
		$direccion = Direcciones::model()->findByPk($model->id_direccion);
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$tipo = TiposContacto::model()->findByName('Celular');
		$contacto = Contactos::model()->findByUser($model->id, $tipo['id'], $perfil->id);
		$contacto_id = $contacto['id'];
		if ($contacto_id) {
			$contacto = Contactos::model()->findByPk($contacto_id);
		}
		else{
			$contacto = new Contactos;
		}

		$transaction = Yii::app()->db->beginTransaction();
		try {
			if(isset($_POST['UnidadesResponsables']))
			{
				$model->attributes=$_POST['UnidadesResponsables'];

				if (isset($_POST['Contactos'])) {
					if (isset($_POST['Contactos']) && $_POST['Contactos']['contacto']) {
						$contacto->attributes=$_POST['Contactos'];
						$tipo = TiposContacto::model()->findByName('Celular');
						$contacto->id_tipos_contacto = $tipo['id'];
						$contacto->id_perfiles = $perfil->id;
						$contacto->id_persona = $model->id;
						if($contacto->validate()){
							$contacto->save();
						}
					}
				}

				if (isset($_POST['Direcciones'])) {
					$direccion->attributes = $_POST['Direcciones'];
					$direccion->save();
				}
				if($model->save()) {
					$transaction->commit();
					$this->redirect(array('view','id'=>$model->id));
				}
				else{
					echo "<script>alert('No se pudo guardar');</script>";
					$transaction->rollback();
				}
			}
		}catch(Exception $ex){
			print_r($e);
			$transaction->rollback();
		}

		$this->render('update',array(
			'model'=>$model,
			'direccion' => $direccion,
			'contacto' => $contacto,
			)
		);
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
		$dataProvider=new CActiveDataProvider('UnidadesResponsables');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->subSection = "Admin";
		$model=new UnidadesResponsables('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['UnidadesResponsables']))
			$model->attributes=$_GET['UnidadesResponsables'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return UnidadesResponsables the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=UnidadesResponsables::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param UnidadesResponsables $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='unidades-responsables-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function obtenerTelefono($data, $row){
		$perfil = Perfiles::model()->findByName("Unidad responsable");
		$tipo = TiposContacto::model()->findByName('Celular');
		$contacto = Contactos::model()->findByUser($data->id, $tipo['id'], $perfil->id);
		return $contacto['contacto'];
	}

}
