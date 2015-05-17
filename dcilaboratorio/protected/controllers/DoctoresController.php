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
		$contactos = array(new Contactos, new Contactos, new Contactos);
		$unidadDoctores = new UnidadTieneDoctores;
		$urs = UnidadesResponsables::model()->findAll();

		$simbolos = array('!', '$', '#', '?');
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$transaction = Yii::app()->db->beginTransaction();
		try
		{
			if(isset($_POST['Doctores']))
			{
				$model->attributes=$_POST['Doctores'];
				$correo = new Contactos;

				$usuario = new Usuarios;
				$usuario->usuario=substr($model->nombre, 0, 3).$model->id.'dci';
				$usuario->contrasena=base64_encode("lab".$simbolos[rand(0, count($simbolos)-1)].$model->id);
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

				if (isset($_POST['Contactos'])) {
					foreach ($contactos as $i => $contacto) {
						if (isset($_POST['Contactos'][$i])) {
							$contacto->attributes=$_POST['Contactos'][$i];
							$contacto->id_tipos_contacto = TiposContacto::model()->findByName($i==0?'Casa':($i==1?'Consultorio':'Celular'))['id'];
							$contacto->id_perfiles = $perfil->id;
							$contacto->id_persona = $usuario->id;
							$contacto->ultima_edicion=date('Y-m-d H:i:s');
							$contacto->usuario_ultima_edicion=Yii::app()->user->id;
							$contacto->creacion=date('Y-m-d H:i:s');
							$contacto->usuario_creacion=Yii::app()->user->id;
							$contacto->save();
						}
					}
				}

				$correo->contacto = $_POST['Doctores']['correo_electronico'];
				$correo->id_tipos_contacto = TiposContacto::model()->findByName('Correo electrónico')['id'];
				$correo->id_perfiles = $perfil->id;
				$correo->id_persona = $usuario->id;
				$correo->ultima_edicion=date('Y-m-d H:i:s');
				$correo->usuario_ultima_edicion=Yii::app()->user->id;
				$correo->creacion=date('Y-m-d H:i:s');
				$correo->usuario_creacion=Yii::app()->user->id;

				if($model->save()){
					if (isset($_POST['UnidadTieneDoctores'])) {
						foreach ($_POST['UnidadTieneDoctores'] as $i => $unidad) {
							foreach ($unidad as $id => $item) {
								$unidadDoctor = new UnidadTieneDoctores;
								$unidadDoctor->id_unidades_responsables = $item;
								$unidadDoctor->id_doctores = $model->id;
								$unidadDoctor->ultima_edicion=date('Y-m-d H:i:s');
								$unidadDoctor->usuario_ultima_edicion=Yii::app()->user->id;
								$unidadDoctor->creacion=date('Y-m-d H:i:s');
								$unidadDoctor->usuario_creacion=Yii::app()->user->id;
								$unidadDoctor->save();
							}
						}
					}
					$correo->save();
					$usuario->usuario=substr($model->nombre, 0, 3).$usuario->id.'dci';
					$usuario->contrasena=base64_encode("lab".$simbolos[rand(0, count($simbolos)-1)].$usuario->id);
					$usuario->save();
					$transaction->commit();
					$this->redirect(array('view','id'=>$model->id));
				}
				else{
					$transaction->rollback();
					echo "<script>alert('No se pudo guardar');</script>";
				}
			}
		}catch(Exception $e)
		{
			print_r($e);
			$transaction->rollback();
		}


		$this->render('create',array(
			'model'=>$model,
			'contactos'=>$contactos,
			'urs'=>$urs,
			'unidad'=>$unidadDoctores,
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
		$contacto_casa_id = Contactos::model()->findByUser($model->id_usuarios, TiposContacto::model()->findByName('Casa')['id'])['id'];
		$contacto_consultorio_id = Contactos::model()->findByUser($model->id_usuarios, TiposContacto::model()->findByName('Consultorio')['id'])['id'];
		$contacto_celular_id = Contactos::model()->findByUser($model->id_usuarios, TiposContacto::model()->findByName('Celular')['id'])['id'];
		$contacto_correo_id = Contactos::model()->findByUser($model->id_usuarios, TiposContacto::model()->findByName('Correo electrónico')['id'])['id'];
		$contactos = array(Contactos::model()->findByPk($contacto_casa_id), Contactos::model()->findByPk($contacto_consultorio_id), Contactos::model()->findByPk($contacto_celular_id));
		$correo = Contactos::model()->findByPk($contacto_correo_id);
		$unidadDoctores = new UnidadTieneDoctores;
		$urs = UnidadesResponsables::model()->findAll();
		// $unidades = Doctores::model()->obtenerUnidadesPorDoctor($id);
		// echo "Todos";
		// print_r($urs);
		// echo "Tiene";
		// print_r($unidades);
		// return;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Doctores']))
		{
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$model->attributes=$_POST['Doctores'];

				if (isset($_POST['Contactos'])) {
					foreach ($contactos as $i => $contacto) {
						if (isset($_POST['Contactos'][$i])) {
							$contacto->attributes=$_POST['Contactos'][$i];
							$contacto->ultima_edicion=date('Y-m-d H:i:s');
							$contacto->usuario_ultima_edicion=Yii::app()->user->id;
							$contacto->creacion=date('Y-m-d H:i:s');
							$contacto->usuario_creacion=Yii::app()->user->id;
							$contacto->save();
						}
					}
				}

				$correo->contacto = $model->correo_electronico;
				$correo->save();

				if($model->save()) {
					if (isset($_POST['UnidadTieneDoctores'])) {
						$unidades = UnidadTieneDoctores::model()->obtenerUnidadesPorDoctor($model->id);
						foreach ($unidades as $unidadExistente) {
							$unidadExistente = UnidadTieneDoctores::model()->findByPk($unidadExistente['id']);
							$unidadExistente->delete();
						}
						foreach ($_POST['UnidadTieneDoctores'] as $i => $unidad) {
							foreach ($unidad as $id => $item) {
								$unidadDoctor = new UnidadTieneDoctores;
								$unidadDoctor->id_unidades_responsables = $item;
								$unidadDoctor->id_doctores = $model->id;
								$unidadDoctor->ultima_edicion=date('Y-m-d H:i:s');
								$unidadDoctor->usuario_ultima_edicion=Yii::app()->user->id;
								$unidadDoctor->creacion=date('Y-m-d H:i:s');
								$unidadDoctor->usuario_creacion=Yii::app()->user->id;
								$unidadDoctor->save();
							}
						}
					}
					$transaction->commit();
					$this->redirect(array('view','id'=>$model->id));
				}
				
			}catch(Exception $ex){
				$transaction->rollback();
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'contactos'=>$contactos,
			'urs'=>$urs,
			'unidad'=>$unidadDoctores,
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
		$titulo = TitulosForm::model()->findByPk($data->id_titulos);
		$completo = $titulo->nombre.' '.$data->nombre.' '.$data->a_paterno.' '.$data->a_materno;
		return $completo;
	}

	public function obtenerNombreEspecialidad($data, $row){
		$especialidad = Especialidades::model()->find($data->id_especialidades);
		return $especialidad->nombre;
	}

	public function obtenerTelefonoConsultorio($data, $row){
		$contacto = Contactos::model()->findByUser($data->id_usuarios, TiposContacto::model()->findByName('Consultorio')['id']);
		return $contacto['contacto'];
	}

	public function obtenerTelefonoCasa($data, $row){
		$contacto = Contactos::model()->findByUser($data->id_usuarios, TiposContacto::model()->findByName('Casa')['id']);
		return $contacto['contacto'];
	}

	public function obtenerTelefonoCelular($data, $row){
		$contacto = Contactos::model()->findByUser($data->id_usuarios, TiposContacto::model()->findByName('Celular')['id']);
		return $contacto['contacto'];
	}

	public function obtenerCorreo($data, $row){
		$contacto = Contactos::model()->findByUser($data->id_usuarios, TiposContacto::model()->findByName('Correo electrónico')['id']);
		return $contacto['contacto'];
	}

	public function obtenerUnidadesResponsables($data, $row){
		$unidades = UnidadTieneDoctores::model()->obtenerUnidadesPorDoctor($data->id);
		$resultado = "";
		foreach ($unidades as $i=>$unidad) {
			if (!$i==0) {
				$resultado.=", ";
			}
			$resultado.=UnidadesResponsables::model()->findByPk($unidad['id_unidades_responsables'])['nombre'];
		}
		return $resultado;
	} 
}
