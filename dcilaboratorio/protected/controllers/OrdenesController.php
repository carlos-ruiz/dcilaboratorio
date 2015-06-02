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
				'actions'=>array('create','update','loadModalContent','agregarExamen','agregarGrupoExamen','ActualizarPrecios'),
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
		$listaTarifasExamenes=array();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ordenes']))
		{
			$model->attributes=$_POST['Ordenes'];
			$paciente->attributes=$_POST['Pacientes'];
			$pagos->attributes=$_POST['Pagos'];

			$fecha_creacion=date('Y-m-d H:i:s');
			$fecha_edicion='2000-01-01 00:00:00';

			$model->fecha_captura=$fecha_creacion;
			$status = Status::model()->findByName("Proceso");
			$model->id_status=$status->id;
			$pagos->fecha=$model->fecha_captura;
			$validaRequiere=true;

			$examenesIds = split(',',$_POST['Examenes']['ids']);
			foreach ($examenesIds as $idExamen) {
				array_push($listaTarifasExamenes, TarifasActivas::model()->find('id_examenes=? AND id_multitarifarios=?', array($idExamen,$model->id_multitarifarios)));
			}

			if($model->requiere_factura==1){
				$datosFacturacion->attributes=$_POST['DatosFacturacion'];
				$direccion->attributes=$_POST['Direcciones'];
				$valida=($datosFacturacion->validate()&$direccion->validate());

			}

			if($model->validate() & $paciente->validate() & $pagos->validate() & $validaRequiere){
				$transaction = Yii::app()->db->beginTransaction();
				try{


					$model->save();
					
					foreach ($examenesIds as $idExamen) {
						array_push($listaTarifasExamenes, TarifasActivas::model()->find('id_examenes=? AND id_multitarifarios=?', array($idExamen,$model->id_multitarifarios)));
						$detallesExamen = DetallesExamen::model()->findByExamenId($idExamen);
						foreach ($detallesExamen as $detalle) {
							$ordenTieneExamenes = new OrdenTieneExamenes;
							$ordenTieneExamenes->id_ordenes=$model->id;
							$ordenTieneExamenes->id_detalles_examen=$detalle->id;
							$ordenTieneExamenes->ultima_edicion=$fecha_edicion;
							$ordenTieneExamenes->usuario_ultima_edicion=Yii::app()->user->id;;
							$ordenTieneExamenes->creacion=$fecha_creacion;
							$ordenTieneExamenes->usuario_creacion=Yii::app()->user->id;;
							$ordenTieneExamenes->save();
						}
					}

					//GENERAR USUARIO PARA EL PACIENTE
					$simbolos = array('!', '$', '#', '?');
					$perfil = Perfiles::model()->findByName("Paciente");
					$user=new Usuarios;

					$user->usuario=substr($paciente->nombre, 0,3);
					$user->contrasena="beforeSave";
					$user->ultima_edicion=$fecha_edicion;
					$user->usuario_ultima_edicion=1;
					$user->creacion=$fecha_creacion;
					$user->usuario_creacion=1;
					$user->id_perfiles=$perfil->id;

					$user->save();
					$user->usuario=strtolower($user->usuario).$user->id."dci";
					$user->contrasena=base64_encode("lab".$simbolos[rand(0, count($simbolos)-1)].$user->id);
					$user->save();

					$paciente->id_usuarios=$user->id;
					$paciente->save();

					$ordenFacturacion = new OrdenesFacturacion;
					if($model->requiere_factura==1){
						$direccion->save();
						$datosFacturacion->id_direccion=$direccion->id;
						$datosFacturacion->save();
						$ordenFacturacion->id_datos_facturacion=$datosFacturacion->id;
					}

					$ordenFacturacion->id_pacientes=$paciente->id;
					$ordenFacturacion->id_ordenes=$model->id;
					$ordenFacturacion->save();

					$pagos->id_ordenes=$model->id;
					$transaction->commit();
					$this->redirect(array('view','id'=>$model->id));

					
				}catch(Exception $e){
					//print_r($e);
					$transaction->rollback();
				}
			}
			
		}

		$this->render('create',array(
			'model'=>$model,
			'paciente'=>$paciente,
			'datosFacturacion'=>$datosFacturacion,
			'examenes'=>$examenes,
			'pagos'=>$pagos,
			'direccion' => $direccion,
			'listaTarifasExamenes'=>$listaTarifasExamenes,
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

	public function actionAgregarExamen(){
		//print_r($_POST);
		$examen=Examenes::model()->findByPk($_POST['id']);
		$tarifa=TarifasActivas::model()->find('id_examenes=? AND id_multitarifarios=?',array($_POST['id'],$_POST['tarifa']));
		$precio=isset($tarifa->precio)?$tarifa->precio:'No hay precio para el tarifario seleccionado';
		echo "<tr class='row_$examen->id' data-id='$examen->id'>
				<td>$examen->clave</td>
				<td>$examen->nombre</td>
				<td class='precioExamen' data-val='$precio'>$ $precio</td>
				<td><a href='js:void(0)' data-id='$examen->id' class='eliminarExamen'><span class='fa fa-trash'></span></a></td>
			</tr>";
	}

	public function actionAgregarGrupoExamen(){
		//print_r($_POST);
		$grupo=Grupos::model()->findByPk($_POST['id']);
		foreach ($grupo->grupoTiene as $tiene) {
			$examen=$tiene->examen;
			$tarifa=TarifasActivas::model()->find('id_examenes=? AND id_multitarifarios=?',array($examen->id,$_POST['tarifa']));
			$precio=isset($tarifa->precio)?$tarifa->precio:'No hay precio para el tarifario seleccionado';
			echo "<tr class='row_$examen->id' data-id='$examen->id'>
					<td>$examen->clave</td>
					<td>$examen->nombre</td>
					<td class='precioExamen' data-val='$precio'>$ $precio</td>
					<td><a href='js:void(0)' data-id='$examen->id' class='eliminarExamen'><span class='fa fa-trash'></span></a></td>
				</tr>";
		}
		
	}

	public function actionActualizarPrecios(){
		$examenes=split(',',$_POST['examenes']);
		$tarifario = $_POST['tarifa'];
		for ($i=0; $i<sizeof($examenes); $i++) {
			$examen=Examenes::model()->findByPk($examenes[$i]);
			$tarifa=TarifasActivas::model()->find('id_examenes=? AND id_multitarifarios=?',array($examenes[$i],$tarifario));
			$precio=isset($tarifa)?$tarifa->precio:'No hay precio para el tarifario seleccionado';
			echo "<tr class='row_$examen->id' data-id='$examen->id'>
					<td>$examen->clave</td>
					<td>$examen->nombre</td>
					<td class='precioExamen' data-val='$precio'>$ $precio</td>
					<td><a href='js:void(0)' data-id='$examen->id' class='eliminarExamen'><span class='fa fa-trash'></span></a></td>
				</tr>";
		}
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
