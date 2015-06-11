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
				'actions'=>array('create','update','loadModalContent','agregarExamen','agregarGrupoExamen','ActualizarPrecios', 'calificar','datosPacienteExistente','agregarPrecio', "accesoPorCorreo"),
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

			$pagos->fecha=$model->fecha_captura;
			$validaRequiereFactura=true;

			
			if($model->requiere_factura==1){
				$datosFacturacion->attributes=$_POST['DatosFacturacion'];
				$direccion->attributes=$_POST['Direcciones'];
				$validaRequiereFactura=($datosFacturacion->validate()&$direccion->validate());
			}

			if($paciente->id>0){
				$paciente->sexo=0;
			}

			$totalAPagar=0;
			$validateExamenes=true;
			$examenesIds=array();
			if(isset($_POST['Examenes']['ids']) && !empty($_POST['Examenes']['ids']))
				$examenesIds = split(',',$_POST['Examenes']['ids']);
			else{
				$mensaje="Debe agregar al menos un examen a la orden";
				$titulo="Aviso";
				$validateExamenes=false;
			}

			
			$examenes_precio = array();
			foreach ($examenesIds as $idExamen) {
				$tarifaActiva=TarifasActivas::model()->find('id_examenes=? AND id_multitarifarios=?', array($idExamen,$model->id_multitarifarios));
				if(isset($tarifaActiva)){
					array_push($listaTarifasExamenes, $tarifaActiva);
					$totalAPagar+=$tarifaActiva->precio;
					$examen_precio = new OrdenPrecioExamen;
					$examen_precio->precio = $tarifaActiva->precio;
					$examen_precio->id_examenes = $idExamen;
					array_push($examenes_precio, $examen_precio);
				}
				else{
					$tarifaAux= new TarifasActivas;
					$tarifaAux->id_examenes=$idExamen;
					$tarifaAux->addError('precio','No hay precio en el tarifario');
					array_push($listaTarifasExamenes, $tarifaAux);
					$validateExamenes=false;
				}
			}
			if(isset($model->descuento)){
				$totalAPagar=$totalAPagar * (1-($model->descuento/100));
			}
			if(isset($model->costo_emergencia))
				$totalAPagar=$totalAPagar+$model->costo_emergencia;

			$totalPagado=(isset($pagos->efectivo)?$pagos->efectivo:0)+(isset($pagos->tarjeta)?$pagos->tarjeta:0)+(isset($pagos->cheque)?$pagos->cheque:0);
			$status = new Status;
			if($totalAPagar<=$totalPagado){
				$cambio = $totalPagado-$totalAPagar;
				if ($pagos->efectivo >= $cambio) {
					$pagos->efectivo -= $cambio; 
				}
				else{
					$cambio -= $pagos->efectivo;
					$pagos->efectivo = 0;
					$pagos->tarjeta -= $cambio;
				}
				$status=Status::model()->findByName("Pagada");
			}
			else
				$status=Status::model()->findByName("Creada");
			$model->id_status=$status->id;

			if($model->validate() & $paciente->validate() & $pagos->validate() & $validaRequiereFactura & $validateExamenes){
				$transaction = Yii::app()->db->beginTransaction();
				try{
					$model->save();
					// print_r($examenes_precio);
					// return;
					foreach ($examenes_precio as $examen_precio) {
						$examen_precio->id_ordenes = $model->id;
						$examen_precio->save();
					}
					
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

					if(isset($paciente->id)&&$paciente->id>0){
						
						$paciente = Pacientes::model()->findByPk($paciente->id);
					}
					else{
						$pacienteAux = Pacientes::model()->findPacientePorNombreYFecha($paciente->nombre, $paciente->a_paterno, $paciente->a_materno, $paciente->fecha_nacimiento);
						if(isset($pacienteAux->id))
							$paciente=$pacienteAux;
					}

					if(!isset($paciente->id)||!$paciente->id>0){
						//GENERAR USUARIO PARA EL PACIENTE
						$simbolos = array('!', '$', '#', '?');
						$perfil = Perfiles::model()->findByName("Paciente");
						$user=new Usuarios;

						$user->usuario=substr($paciente->nombre, 0,3);
						$user->contrasena="beforeSave";
						$user->ultima_edicion=$fecha_edicion;
						$user->usuario_ultima_edicion=Yii::app()->user->id;
						$user->creacion=$fecha_creacion;
						$user->usuario_creacion=Yii::app()->user->id;
						$user->id_perfiles=$perfil->id;

						$user->save();
						$user->usuario=strtolower($user->usuario).$user->id."dci";
						$user->contrasena=base64_encode("lab".$simbolos[rand(0, count($simbolos)-1)].$user->id);
						$user->save();

						$paciente->id_usuarios=$user->id;
						$paciente->save();
					}

					$ordenFacturacion = new OrdenesFacturacion;
					if($model->requiere_factura==1){
						$direccion->save();
						$datosFacturacion->id_direccion=$direccion->id;
						$datosFacturacion->save();
						$ordenFacturacion->id_datos_facturacion=$datosFacturacion->id;
					}
					if($paciente->id>0)
						$ordenFacturacion->id_pacientes=$paciente->id;
					
					$ordenFacturacion->id_ordenes=$model->id;
					$ordenFacturacion->save();

					$pagos->id_ordenes=$model->id;
					if($totalPagado>0)
						$pagos->save();

					$transaction->commit();
					if(!isset($user))
						$user=Usuarios::model()->findByPk($paciente->id_usuarios);
					
					$nombrePaciente = $paciente->nombre." ".$paciente->a_paterno." ".$paciente->a_materno;
					$this->enviarAccesoPorCorreo($nombrePaciente, $user->usuario, base64_decode($user->contrasena), $paciente->email);
					$this->redirect(array('view','id'=>$model->id));

					
				}catch(Exception $e){
					//print_r($e);
					//return;
					$transaction->rollback();
					$mensaje="Ocurrió un error inesperado, verifica los datos e intenta de nuevo";
					$titulo="Aviso";
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
		$this->renderPartial('/comunes/mensaje',array('mensaje'=>isset($mensaje)?$mensaje:"",'titulo'=>isset($titulo)?$titulo:""));
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
		$this->subSection = "Admin";
		$model=new Ordenes('search');
		
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Ordenes']))
			$model->attributes=$_GET['Ordenes'];

		$this->render('admin',array(
			'model'=>$model,
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

	public function actionLoadModalContent($id_ordenes){
		if (isset($id_ordenes)) {
			$orden = $this->loadModel($id_ordenes);
		}
		$precios = $orden->precios;
		$totalOrden = 0;
		$totalPagado = 0;
		foreach ($precios as $precio) {
			$totalOrden += $precio->precio;
		}
		$pagosAnteriores = $orden->pagos;
		foreach ($pagosAnteriores as $pagoRealizado) {
			$totalPagado += $pagoRealizado->efectivo + $pagoRealizado->tarjeta + $pagoRealizado->cheque;
		}

		$transaction = Yii::app()->db->beginTransaction();
		try{
			$pagos=new Pagos;
			if (isset($_POST['Pagos'])) {
				$pagos->attributes = $_POST['Pagos'];
				$pagos->id_ordenes = $orden->id;
				$totalPagado += $pagos->efectivo + $pagos->tarjeta + $pagos->cheque;
				if($totalOrden <= $totalPagado){
					$cambio = $totalPagado-$totalOrden;
					if ($pagos->efectivo >= $cambio) {
						$pagos->efectivo -= $cambio; 
					}
					else {
						$cambio -= $pagos->efectivo;
						$pagos->efectivo = 0;
						$pagos->tarjeta -= $cambio;
					}
					$statusPagada=Status::model()->findByName("Pagada");
					$statusCalificada=Status::model()->findByName("Calificada");
					$statusFinalizada=Status::model()->findByName("Finalizada");
					if ($orden->id_status == $statusCalificada->id) {
						$orden->id_status = $statusFinalizada->id;
					}
					else{
						$orden->id_status = $statusPagada->id;
					}
					$orden->ultima_edicion = date('Y-m-d H:i:s');
					$orden->usuario_ultima_edicion = Yii::app()->user->id;
					$orden->save();
				}
				$pagos->ultima_edicion = '2000-01-01 00:00:00';
				$pagos->usuario_ultima_edicion = Yii::app()->user->id;
				$pagos->creacion = date('Y-m-d H:i:s');
				$pagos->usuario_creacion = Yii::app()->user->id;
				$pagos->fecha = date('Y-m-d H:i:s');
				$pagos->save();
				$transaction->commit();
				$this->redirect(array('view','id'=>$orden->id));
			}
		}
		catch(Exception $ex){
			$transaction->rollback();
		}
		$form=$this->beginWidget('CActiveForm', array(
			'id'=>'pagos-form',
			// Please note: When you enable ajax validation, make sure the corresponding
			// controller action is handling ajax validation correctly.
			// There is a call to performAjaxValidation() commented in generated controller code.
			// See class documentation of CActiveForm for details on this.
			'enableAjaxValidation'=>false,
		)); 
		$this->renderPartial("_modalPagos",
			array('pagos'=>$pagos,'form'=>$form, 'orden'=>$orden)
			);
		$this->endWidget();
	}

	public function actionCalificar($id){
		$model = $this->loadModel($id);
		$ordenExamenes = array();

		$ordenTieneExamenes = $model->ordenTieneExamenes;
		foreach ($ordenTieneExamenes as $ordenExamen) {
			array_push($ordenExamenes, $ordenExamen);
		}

		if (isset($_POST['OrdenTieneExamenes'])) {
			$calificada = true;
			foreach ($_POST['OrdenTieneExamenes'] as $i => $value) {
				$ordenExamenToSave = $ordenExamenes[$i];
				$ordenExamenToSave->resultado = $value['resultado'];
				$ordenExamenToSave->save();
				$calificada = $ordenExamenToSave->resultado!=""; 
			}
			$statusPagada=Status::model()->findByName("Pagada");
			$statusCalificada=Status::model()->findByName("Calificada");
			$statusFinalizada=Status::model()->findByName("Finalizada");
			$statusCreada=Status::model()->findByName("Creada");

			if($model->id_status == $statusPagada->id && $calificada){
				$model->id_status = $statusFinalizada->id;
				$model->save();
			}
			elseif (!$calificada && $model->id_status == $statusFinalizada->id) {
				$model->id_status = $statusPagada->id;
				$model->save();
			}
			elseif ($calificada && $model->id_status == $statusCreada->id) {
				$model->id_status = $statusCalificada->id;
				$model->save();
			}
			$this->redirect(array('view','id'=>$model->id));
		}
		$this->render('_calificar',array(
			'model'=>$model,
			'ordenExamenesModel'=>$ordenExamenes,
		));
	}

	public function actionAgregarExamen(){
		//print_r($_POST);
		$examen=Examenes::model()->findByPk($_POST['id']);
		$tarifa=TarifasActivas::model()->find('id_examenes=? AND id_multitarifarios=?',array($_POST['id'],$_POST['tarifa']));
		$precio=isset($tarifa->precio)?$tarifa->precio:0;
		$precioText=isset($tarifa->precio)?'$ '.$tarifa->precio:'No hay precio para el tarifario seleccionado';
		$agregarPrecio = isset($tarifa->precio)?"":"<a href='js:void(0)' data-id='$examen->id' class='btn default blue-stripe agregarPrecio' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;'>Agregar precio</a><input type='text' class='form-control input-small' id='addPrecio_$examen->id' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;' />";
		echo "<tr class='row_$examen->id' data-id='$examen->id'>
				<td>$examen->clave</td>
				<td>$examen->nombre</td>
				<td class='precioExamen' data-val='$precio'>$precioText $agregarPrecio</td>
				<td><a href='js:void(0)' data-id='$examen->id' class='eliminarExamen'><span class='fa fa-trash'></span></a></td>
			</tr>";
	}

	public function actionAgregarGrupoExamen(){
		//print_r($_POST);
		$grupo=Grupos::model()->findByPk($_POST['id']);
		foreach ($grupo->grupoTiene as $tiene) {
			$examen=$tiene->examen;
			if($examen->activo==1 && sizeof($examen->detallesExamenes)>0 && $examen->tieneResultadosActivos()){
				$tarifa=TarifasActivas::model()->find('id_examenes=? AND id_multitarifarios=?',array($examen->id,$_POST['tarifa']));
				$precio=isset($tarifa->precio)?$tarifa->precio:0;
				$precioText=isset($tarifa->precio)?"$ ".$tarifa->precio:'No hay precio para el tarifario seleccionado';
				$agregarPrecio = isset($tarifa->precio)?"":"<a href='js:void(0)' data-id='$examen->id' class='btn default blue-stripe agregarPrecio' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;'>Agregar precio</a><input type='text' class='form-control input-small' id='addPrecio_$examen->id' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;' />";
				echo "<tr class='row_$examen->id' data-id='$examen->id'>
						<td>$examen->clave</td>
						<td>$examen->nombre</td>
						<td class='precioExamen' data-val='$precio'>$precioText $agregarPrecio</td>
						<td><a href='js:void(0)' data-id='$examen->id' class='eliminarExamen'><span class='fa fa-trash'></span></a></td>
					</tr>";
			}
		}
		
	}

	public function actionActualizarPrecios(){
		$examenes=split(',',$_POST['examenes']);
		$tarifario = $_POST['tarifa'];
		for ($i=0; $i<sizeof($examenes); $i++) {
			$examen=Examenes::model()->findByPk($examenes[$i]);
			if(sizeof($examen->detallesExamenes)>0 && $examen->tieneResultadosActivos()){
				$tarifa=TarifasActivas::model()->find('id_examenes=? AND id_multitarifarios=?',array($examenes[$i],$tarifario));
				$precio=isset($tarifa->precio)?$tarifa->precio:0;
				$precioText=isset($tarifa->precio)?"$ ".$tarifa->precio:'No hay precio para el tarifario seleccionado';
				$agregarPrecio = isset($tarifa->precio)?"":"<a href='js:void(0)' data-id='$examen->id' class='btn default blue-stripe agregarPrecio' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;'>Agregar precio</a><input type='text' class='form-control input-small' id='addPrecio_$examen->id' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;' />";
				echo "<tr class='row_$examen->id' data-id='$examen->id'>
						<td>$examen->clave</td>
						<td>$examen->nombre</td>
						<td class='precioExamen' data-val='$precio'>$precioText $agregarPrecio</td>
						<td><a href='js:void(0)' data-id='$examen->id' class='eliminarExamen'><span class='fa fa-trash'></span></a></td>
					</tr>";
			}
		}
	}

	public function actionAgregarPrecio(){
		$examenId=$_POST['id'];
		$tarifario = $_POST['tarifa'];
		$precio=$_POST['precio'];

		$tarifa = new TarifasActivas;
		$tarifa->id_examenes=$examenId;
		$tarifa->id_multitarifarios=$tarifario;
		$tarifa->precio=$precio;
		$tarifa->ultima_edicion='2000-01-01 00:00:00';
		$tarifa->usuario_ultima_edicion=Yii::app()->user->id;
		$tarifa->creacion=date('Y-m-d H:i:s');
		$tarifa->usuario_creacion=Yii::app()->user->id;
		$tarifa->save();

		$examen=Examenes::model()->findByPk($examenId);
		echo "<td>$examen->clave</td>
					<td>$examen->nombre</td>
					<td class='precioExamen' data-val='$precio'>$ $precio</td>
					<td><a href='js:void(0)' data-id='$examen->id' class='eliminarExamen'><span class='fa fa-trash'></span></a></td>
				";
	}

	public function enviarAccesoPorCorreo($nombrePaciente, $usuario, $contrasena, $correo){
		$mail = new YiiMailer();
		$mail->setView('enviarContrasena');
		$mail->setData(array('nombreCompleto' => $nombrePaciente, 'usuario' => $usuario, 'contrasena' => $contrasena,));
		$mail->setFrom('clientes@dcilaboratorio.com', 'DCI Laboratorio');
		$mail->setTo($correo);
		$mail->setSubject('Bienvenido a DCI Laboratorio');
		if ($mail->send()) {
			Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
		} else {
			Yii::app()->user->setFlash('error','Error while sending email: '.$mail->getError());
		}
	} 

	public function actionDatosPacienteExistente(){
		$paciente = Pacientes::model()->findByPk($_POST['id']);
		$json = json_encode( (array)$paciente->getAttributes() );
		echo $json;
	}

	public function obtenerPaciente($data, $row){
		$paciente = $data->ordenFacturacion->paciente;
		$completo = $paciente->nombre.' '.$paciente->a_paterno.' '.$paciente->a_materno;
		return $completo;
	}

	public function obtenerNombreCompletoDoctor($data, $row){		
		$doctor =Doctores::model()->findByAttributes(array('id'=>$data['id_doctores']));
		$titulo = TitulosForm::model()->findByPk($doctor->id_titulos);
		$completo = $titulo->nombre.' '.$doctor->nombre.' '.$doctor->a_paterno.' '.$doctor->a_materno;
		return $completo;
	}

	public function obtenerSioNoComparteDr($data, $row){		
		if ($data['compartir_con_doctor'] == 1)
			$var = "Sí";
		else
			$var = "No";
		return $var;
	}

	public function obtenerGenero($data, $row){		
		$paciente =Pacientes::model()->findByAttributes(array('id'=>$data['id_pacientes']));
		if ($paciente['sexo'] == 1)
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
