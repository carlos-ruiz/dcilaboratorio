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
		$direccion = new Direcciones;
		$urs = UnidadesResponsables::model()->findAll();
		$unidadesSeleccionadas=array();
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

				if(isset($_POST['Direcciones'])){
					$direccion->attributes = $_POST['Direcciones'];
					$direccion->ultima_edicion=date('Y-m-d H:i:s');
					$direccion->usuario_ultima_edicion=Yii::app()->user->id;
					$direccion->creacion=date('Y-m-d H:i:s');
					$direccion->usuario_creacion=Yii::app()->user->id;
					$direccion->save();
				}

				$model->id_direccion=$direccion->id;

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

					if (isset($_POST['Contactos'])) {
						foreach ($contactos as $i => $contacto) {
							if (isset($_POST['Contactos'][$i])) {
								$contacto->attributes=$_POST['Contactos'][$i];
								$tip = TiposContacto::model()->findByName($i==0?'Casa':($i==1?'Consultorio':'Celular'));
								$contacto->id_tipos_contacto = $tip['id'];
								$contacto->id_perfiles = $perfil->id;
								$contacto->id_persona = $model->id;
								$contacto->ultima_edicion=date('Y-m-d H:i:s');
								$contacto->usuario_ultima_edicion=Yii::app()->user->id;
								$contacto->creacion=date('Y-m-d H:i:s');
								$contacto->usuario_creacion=Yii::app()->user->id;
								$contacto->save();
							}
						}
					}

					$correo->contacto = $_POST['Doctores']['correo_electronico'];
					$tip = TiposContacto::model()->findByName('Correo electrónico');
					$correo->id_tipos_contacto = $tip['id'];
					$correo->id_perfiles = $perfil->id;
					$correo->id_persona = $model->id;
					$correo->ultima_edicion=date('Y-m-d H:i:s');
					$correo->usuario_ultima_edicion=Yii::app()->user->id;
					$correo->creacion=date('Y-m-d H:i:s');
					$correo->usuario_creacion=Yii::app()->user->id;
					$correo->save();

					$usuario->usuario=substr($model->nombre, 0, 3).$usuario->id.'dci';
					$usuario->contrasena=base64_encode("lab".$simbolos[rand(0, count($simbolos)-1)].$usuario->id);
					$usuario->save();

					$transaction->commit();

					if ($correo->contacto == '') {
						$this->redirect(array('view','id'=>$model->id));
					}
					$titulo = TitulosForm::model()->findByPk($model->id_titulos);
					$nombreDoctor = $titulo->nombre.' '.$model->nombre.' '.$model->a_paterno.' '.$model->a_materno;
					$this->enviarAccesoPorCorreo($nombreDoctor, $usuario->usuario, base64_decode($usuario->contrasena), $correo->contacto);

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
			'unidadesSeleccionadas'=>$unidadesSeleccionadas,
			'direccion' => $direccion,
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
		$perfil = Perfiles::model()->findByName("Doctor");
		$model = $this->loadModel($id);
		$direccion = Direcciones::model()->findByPk($model->id_direccion);
		$tipo = TiposContacto::model()->findByName('Casa');
		$contact = Contactos::model()->findByUser($model->id, $tipo['id'], $perfil->id);
		$contacto_casa_id = $contact['id'];

		$tipo = TiposContacto::model()->findByName('Consultorio');
		$contact = Contactos::model()->findByUser($model->id, $tipo['id'], $perfil->id);
		$contacto_consultorio_id = $contact['id'];

		$tipo = TiposContacto::model()->findByName('Celular');
		$contact = Contactos::model()->findByUser($model->id, $tipo['id'], $perfil->id);
		$contacto_celular_id = $contact['id'];

		$tipo = TiposContacto::model()->findByName('Correo electrónico');
		$contact = Contactos::model()->findByUser($model->id, $tipo['id'], $perfil->id);
		$contacto_correo_id = $contact['id'];

		$contactos = array();
		if ($contacto_casa_id) {
			$contactos[] = Contactos::model()->findByPk($contacto_casa_id);
		}
		else{
			$contactos[] = new Contactos;
		}

		if ($contacto_consultorio_id) {
			$contactos[] = Contactos::model()->findByPk($contacto_consultorio_id);
		}
		else{
			$contactos[] = new Contactos;
		}

		if ($contacto_celular_id) {
			$contactos[] = Contactos::model()->findByPk($contacto_celular_id);
		}
		else{
			$contactos[] = new Contactos;
		}
		
		$correo = Contactos::model()->findByPk($contacto_correo_id);
		$unidadDoctores = new UnidadTieneDoctores;
		$urs = UnidadesResponsables::model()->findAll();
		$perfil = Perfiles::model()->findByName("Doctor");

		$unidadDoctoresAux = $model->unidadTieneDoctores;
		$unidadesSeleccionadas = array();
		foreach ($unidadDoctoresAux as $unidadDoctor) {
			$unidadesSeleccionadas[$unidadDoctor->id_unidades_responsables]=array('selected' => 'selected');
		}

		if(isset($_POST['Doctores']))
		{
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$model->attributes=$_POST['Doctores'];
				$correo->contacto = $_POST['Doctores']['correo_electronico'];
				$correo->save();
				if (isset($_POST['Contactos'])) {
					foreach ($contactos as $i => $contacto) {
						$contactoBorrar = Contactos::model()->findByPk($contacto->id);
						if (isset($contactoBorrar)) {
							if ($_POST['Contactos'][$i]['contacto']=='') {
								$contactoBorrar->delete();
								continue;
							}
						}
						if (isset($_POST['Contactos'][$i]) && $_POST['Contactos'][$i]['contacto']) {
							
							$contacto->attributes=$_POST['Contactos'][$i];
							$tipo = TiposContacto::model()->findByName($i==0?'Casa':($i==1?'Consultorio':'Celular'));
							$contacto->id_tipos_contacto = $tipo['id'];
							$contacto->id_perfiles = $perfil->id;
							$contacto->id_persona = $model->id;
							$contacto->ultima_edicion=date('Y-m-d H:i:s');
							$contacto->usuario_ultima_edicion=Yii::app()->user->id;
							$contacto->creacion=date('Y-m-d H:i:s');
							$contacto->usuario_creacion=Yii::app()->user->id;
							if($contacto->validate()){
								$contacto->save();
							}
						}
					}
				}

				if (isset($_POST['Direcciones'])) {
					$direccion->attributes = $_POST['Direcciones'];
					$direccion->save();
				}

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
				echo "<script>alert('No se pudo guardar');</script>";
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'contactos'=>$contactos,
			'urs'=>$urs,
			'unidad'=>$unidadDoctores,
			'unidadesSeleccionadas'=>$unidadesSeleccionadas,
			'direccion'=>$direccion,
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
		$perfil = Perfiles::model()->findByName("Doctor");
		$tipo = TiposContacto::model()->findByName('Consultorio');
		$contacto = Contactos::model()->findByUser($data->id, $tipo['id'], $perfil->id);
		return $contacto['contacto'];
	}

	public function obtenerTelefonoCasa($data, $row){
		$perfil = Perfiles::model()->findByName("Doctor");
		$tipo = TiposContacto::model()->findByName('Casa');
		$contacto = Contactos::model()->findByUser($data->id, $tipo['id'], $perfil->id);
		return $contacto['contacto'];
	}

	public function obtenerTelefonoCelular($data, $row){
		$perfil = Perfiles::model()->findByName("Doctor");
		$tipo = TiposContacto::model()->findByName('Celular');
		$contacto = Contactos::model()->findByUser($data->id, $tipo['id'], $perfil->id);
		return $contacto['contacto'];
	}

	public function obtenerCorreo($data, $row){
		$perfil = Perfiles::model()->findByName("Doctor");
		$tipo = TiposContacto::model()->findByName('Correo electrónico');
		$contacto = Contactos::model()->findByUser($data->id, $tipo['id'], $perfil->id);
		return $contacto['contacto'];
	}

	public function obtenerUnidadesResponsables($data, $row){
		$unidades = UnidadTieneDoctores::model()->obtenerUnidadesPorDoctor($data->id);
		$resultado = "";
		foreach ($unidades as $i=>$unidad) {
			if (!$i==0) {
				$resultado.=", ";
			}
			$ur = UnidadesResponsables::model()->findByPk($unidad['id_unidades_responsables']);
			$resultado.=$ur['nombre'];
		}
		return $resultado;
	}

	public function enviarAccesoPorCorreo($nombreDoctor, $usuario, $contrasena, $correo){
		$mail = new YiiMailer();
		$mail->setView('enviarContrasena');
		$mail->setData(array('nombreCompleto' => $nombreDoctor, 'usuario' => $usuario, 'contrasena' => $contrasena,));
		$mail->setFrom('clientes@dcilaboratorio.com', 'DCI Laboratorio');
		$mail->setTo($correo);
		$mail->setSubject('Bienvenido a DCI Laboratorio');
		if ($mail->send()) {
			Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
		} else {
			Yii::app()->user->setFlash('error','Error while sending email: '.$mail->getError());
		}
	}
}
