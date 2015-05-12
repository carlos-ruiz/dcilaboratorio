<?php

class DoctoresController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $section = "Doctores";
	public $subSection;
	public $pageTitle="Doctores";

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
		$this->subSection = "Nuevo";
		$model = new Doctores;
		$contacto = new Contactos;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Doctores']))
		{
			print_r($_POST['Contactos']);
			$model->attributes=$_POST['Doctores'];
			$casa = new Contactos;
			$consultorio = new Contactos;
			$celular = new Contactos;
			$correo = new Contactos;

			$usuario = new Usuarios;
			$usuario->usuario=substr($model->nombre, 0, 2).substr($model->a_paterno, 0, 2).substr($model->a_materno, 0, 2);
			$usuario->contrasena=md5("doctor");
			$usuario->ultima_edicion=date('Y-m-d H:i:s');
			$usuario->usuario_ultima_edicion=Yii::app()->user->id;
			$usuario->creacion=date('Y-m-d H:i:s');
			$usuario->usuario_creacion=Yii::app()->user->id;

			if($perfil = Perfiles::model()->findByName("Doctor")){			
				$usuario->id_perfiles=$perfil->id;
			}
			else{
				$perfil = new Perfiles;
				$perfil->nombre="Doctor";
				$perfil->save();
				$usuario->id_perfiles=$perfil->id;	
			}
			$usuario->save();

			$model->id_usuarios=$usuario->id;

			$casa->contacto = $_POST['Contactos']['contactoCasa'];
			$casa->id_tipos_contacto = TiposContacto::model()->findByName('Casa')['id'];
			$casa->id_perfiles = $perfil->id;
			$casa->id_persona = $usuario->id;
			$casa->ultima_edicion=date('Y-m-d H:i:s');
			$casa->usuario_ultima_edicion=Yii::app()->user->id;
			$casa->creacion=date('Y-m-d H:i:s');
			$casa->usuario_creacion=Yii::app()->user->id;

			$consultorio->contacto = $_POST['Contactos']['contactoConsultorio'];
			$consultorio->id_tipos_contacto = TiposContacto::model()->findByName('Consultorio')['id'];
			$consultorio->id_perfiles = $perfil->id;
			$consultorio->id_persona = $usuario->id;
			$consultorio->ultima_edicion=date('Y-m-d H:i:s');
			$consultorio->usuario_ultima_edicion=Yii::app()->user->id;
			$consultorio->creacion=date('Y-m-d H:i:s');
			$consultorio->usuario_creacion=Yii::app()->user->id;

			$celular->contacto = $_POST['Contactos']['contactoCelular'];
			$celular->id_tipos_contacto = TiposContacto::model()->findByName('Celular')['id'];
			$celular->id_perfiles = $perfil->id;
			$celular->id_persona = $usuario->id;
			$celular->ultima_edicion=date('Y-m-d H:i:s');
			$celular->usuario_ultima_edicion=Yii::app()->user->id;
			$celular->creacion=date('Y-m-d H:i:s');
			$celular->usuario_creacion=Yii::app()->user->id;

			$correo->contacto = $_POST['Doctores']['correo_electronico'];
			$correo->id_tipos_contacto = TiposContacto::model()->findByName('Correo electrónico')['id'];
			$correo->id_perfiles = $perfil->id;
			$correo->id_persona = $usuario->id;
			$correo->ultima_edicion=date('Y-m-d H:i:s');
			$correo->usuario_ultima_edicion=Yii::app()->user->id;
			$correo->creacion=date('Y-m-d H:i:s');
			$correo->usuario_creacion=Yii::app()->user->id;

			if($model->save()){
				$casa->save();
				$consultorio->save();
				$celular->save();
				$correo->save();
				$this->redirect(array('view','id'=>$model->id));
			}
			else{
				echo "<script>alert('No se pudo guardar');</script>";
			}
		}

		$this->render('create',array(
			'model'=>$model, 
			'contacto'=>$contacto,
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
		$contacto = new Contactos;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Doctores']))
		{
			$model->attributes=$_POST['Doctores'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
			'contacto'=>$contacto,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Doctores');
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
		$model=new Doctores('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Doctores']))
			$model->attributes=$_GET['Doctores'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Doctores the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Doctores::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Doctores $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='doctores-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function obtenerNombreCompletoConTitulo($data, $row){
		$titulo = TitulosForm::model()->find($data->id_titulos);
		$completo = $titulo->nombre.' '.$data->nombre.' '.$data->a_paterno.' '.$data->a_materno;
		return $completo;
	}

	public function obtenerNombreEspecialidad($data, $row){
		$especialidad = Especialidades::model()->find($data->id_especialidades);
		return $especialidad->nombre;
	}
}
