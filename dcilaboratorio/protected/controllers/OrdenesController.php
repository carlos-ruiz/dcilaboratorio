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

	public $examenesImpresos=array();
	public $nivelImpresionSubgrupo=0;

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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view', 'create','admin','update','loadModalContent','agregarExamen','agregarGrupoExamen','ActualizarPrecios', 'calificar','datosPacienteExistente','agregarPrecio', "accesoPorCorreo", 'generarPdf', 'imprimirResultadosPdf', 'delete', 'gruposPorExamen','imprimirResultadosArchivo'),
				'users'=>Usuarios::model()->obtenerPorPerfil('Administrador'),
				),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','index','view','imprimirResultadosPdf'),
				'users'=>array_merge(Usuarios::model()->obtenerPorPerfil('Paciente'), Usuarios::model()->obtenerPorPerfil('Doctor')),
				),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('generarPdf'),
				'users'=>Usuarios::model()->obtenerPorPerfil('Paciente'),
				),
			array('deny',  // deny all users
				'users'=>array('*'),
				),
			);
	}

	public function imprimirGrupo($idGrupo,$idOrden,$editable=true){
        $grupo = Grupos::model()->findByPk($idGrupo);
        echo '<thead><tr>
						<th colspan="4" style="color:#59F36D">'.$grupo->nombre.'</th>'.
					'</tr></thead>';
        $perfilDePerfiles = GruposPerfiles::model()->findAll('id_grupo_padre=?', array($idGrupo));
        
        if(empty($perfilDePerfiles)){//Quiere decir que NO es es perfilote
            foreach ($grupo->grupoTiene as $grupoExamen) {
        		echo '<thead><tr>
					<th colspan="4" style="color:#1e90ff">'.$grupoExamen->examen->nombre.'</th>'.
				'</tr></thead>';
				
                foreach ($grupoExamen->examen->detallesExamenes as $detalleExamen) {
                    if(!in_array($detalleExamen->id_examenes, $this->examenesImpresos)){
                    	
                        //Pintamos el examen
                        array_push($this->examenesImpresos, $detalleExamen->id_examenes);
                        $rango=$detalleExamen->rango_inferior.'-'.$detalleExamen->rango_promedio.'-'.$detalleExamen->rango_superior;

                        //echo $detalleExamen->descripcion;
                        $ordenExamen = OrdenTieneExamenes::model()->find('id_ordenes=? AND id_detalles_examen=?', array($idOrden, $detalleExamen->id));
                        if($ordenExamen->resultado > $detalleExamen->rango_superior || $ordenExamen->resultado < $detalleExamen->rango_inferior){
                            //$this->SetFont('Times','BI',8);
                            //$this->SetTextColor(255, 0, 0);
                        }
                        //echo $ordenExamen->resultado;
                        //$this->SetTextColor(0, 0, 0);
                        //$this->SetFont('Arial','',7.5);
                        //echo $detalleExamen->unidadesMedida->abreviatura;
                        //echo $rango;
                        echo '
					<tr>
						<td>'.$detalleExamen->descripcion.'</td>';
						if($editable)
							echo'<td><input size="25" maxlength="25" class="form-control" name="OrdenTieneExamenes['.$ordenExamen->id.'][resultado]" id="OrdenTieneExamenes_'.$ordenExamen->id.'_resultado" value="'.$ordenExamen->resultado.'" type="text"></td>';
						else {
							echo'<td>';
							if(isset($ordenExamen->resultado)&&strlen($ordenExamen->resultado)>0) echo $ordenExamen->resultado; else echo 'Sin Resultado';
							echo '</td>';
						}
						echo '<td>'.$detalleExamen->unidadesMedida->nombre.'</td>'.
						'<td>'.$rango.'</td>'.
					'</tr>';
					}
                }
            }
        }else{
            $hijos = GruposPerfiles::model()->findAll('id_grupo_padre=?', array($idGrupo));
  
            foreach ($hijos as $grupoHijo) {

                $this->nivelImpresionSubgrupo++;
                $this->imprimirGrupo($grupoHijo->id_grupo_hijo,$idOrden,$editable);
                if($editable){
                 echo '<tr><td colspan="4"><textarea class="width-all" value="asdasdasd" placeholder="Comentarios: '.$grupo->nombre.'" name="comentario_perfil['.$grupoHijo->id_grupo_hijo.']"></textarea></td></tr>';
        		}else{
        			$ordenTieneGrupos = OrdenTieneGrupos::model()->find("id_ordenes=? AND id_grupos=?",array($idOrden,$idGrupo));
        			if(isset($ordenTieneGrupos->comentarios_perfil)){
        				echo '<tr><td colspan="4">'.$ordenTieneGrupos->comentarios_perfil.'</td></tr>';
        			}
        		}
        		$this->nivelImpresionSubgrupo--;
            }

            $examenesEnGruposHijo=array();
            foreach ($hijos as $grupoHijo) {
                $grupoExamenes=GrupoExamenes::model()->findAll('id_grupos_examenes=?',array($grupoHijo->id_grupo_hijo));
                foreach ($grupoExamenes as $grupoExamen) {
                    array_push($examenesEnGruposHijo, $grupoExamen->examen);
                }
            }
            if(sizeof($grupo->grupoTiene)>sizeof($examenesEnGruposHijo)){
                //echo "OTROS";
                echo '<thead><tr>
						<th colspan="4" style="color:#59F36D">OTROS</th>'.
					'</tr></thead>';
                foreach ($grupo->grupoTiene as $grupoExamen) {
                	if(!in_array($grupoExamen->examen->id, $this->examenesImpresos)){
	            		echo '<thead><tr>
							<th colspan="4" style="color:#1e90ff">'.$grupoExamen->examen->nombre.'</th>'.
						'</tr></thead>';
					}
                    if(!in_array($grupoExamen->examen, $examenesEnGruposHijo) && !in_array($grupoExamen->examen->id, $this->examenesImpresos)){

                        array_push($this->examenesImpresos, $grupoExamen->examen->id);
                        foreach ($grupoExamen->examen->detallesExamenes as $detalleExamen) {
                        	$rango=$detalleExamen->rango_inferior.'-'.$detalleExamen->rango_promedio.'-'.$detalleExamen->rango_superior;
                            //echo $detalleExamen->descripcion;
                            //echo $idOrden." --- ".$detalleExamen->id;

                            $ordenExamen = OrdenTieneExamenes::model()->find('id_ordenes=? AND id_detalles_examen=?', array($idOrden, $detalleExamen->id));
                           	$idOrdenExamen = $ordenExamen['id'];
                           	$valueOrdenExamen = $ordenExamen['resultado'];
                           	//echo $ordenExamen->id."<br />";
         
                            //if($ordenExamen->resultado > $detalleExamen->rango_superior || $ordenExamen->resultado < $detalleExamen->rango_inferior){
                                //$this->SetFont('Times','BI',8);
                                //$this->SetTextColor(255, 0, 0);
                            //}
                            //rojo o negro
                            //echo isset($ordenExamen->resultado)?$ordenExamen->resultado:"";
                            //negro
                            //echo $detalleExamen->unidadesMedida->abreviatura;
                            //echo $rango;

                            echo '
							<tr>
								<td>'.$detalleExamen->descripcion.'</td>';
								if($editable){
									echo '<td><input size="25" maxlength="25" class="form-control" name="OrdenTieneExamenes['.$idOrdenExamen.'][resultado]" id="OrdenTieneExamenes_'.$idOrdenExamen.'_resultado" value="'.$valueOrdenExamen.'" type="text"></td>';
								}
								else {
									echo'<td>';
									if(isset($ordenExamen->resultado)&&strlen($ordenExamen->resultado)>0) echo $ordenExamen->resultado; else echo 'Sin Resultado';
									echo '</td>';
								}
								echo '<td>'.$detalleExamen->unidadesMedida->nombre.'</td>'.
								'<td>'.$rango.'</td>'.
							'</tr>';
                            
                        }
                    }
                }
            }
            
        }
        if($this->nivelImpresionSubgrupo==0){
        		if($editable){
                 echo '<tr><td colspan="4"><textarea class="width-all" value="" placeholder="Comentarios: '.$grupo->nombre.'" name="comentario_perfil['.$idGrupo.']"></textarea></td></tr>';
        		}else{
        			$ordenTieneGrupos = OrdenTieneGrupos::model()->find("id_ordenes=? AND id_grupos=?",array($idOrden,$idGrupo));
        			if(isset($ordenTieneGrupos->comentarios_perfil)){
        				echo '<tr><td colspan="4">'.$ordenTieneGrupos->comentarios_perfil.'</td></tr>';
        			}
        		}
            }
    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$orden = $this->loadModel($id);

		$ordenExamenes = array();
		$ordenGrupos = array();
		$ordenGrupotes = array();

		$ordenTieneExamenes = $orden->ordenTieneExamenes;
		foreach ($ordenTieneExamenes as $ordenExamen) {
			array_push($ordenExamenes, $ordenExamen);
		}
		$ordenTieneGrupos = $orden->ordenTieneGrupos;
		foreach ($ordenTieneGrupos as $ordenGrupo) {
			array_push($ordenGrupos, $ordenGrupo);
			if(GruposPerfiles::model()->count("id_grupo_padre=?",array($ordenGrupo->id_grupos))>0){
				array_push($ordenGrupotes,$ordenGrupo->grupo);
			}
		}
		if(Yii::app()->user->getState('perfil')=='Doctor'){
			$doctor = Doctores::model()->find("id_usuarios=?",array(Yii::app()->user->id));
			if(!($orden->id_doctores==$doctor->id && $orden->compartir_con_doctor==1)){
				$this->render('/site/error',array(
					'code'=>403,
					'message'=>"Usted no se encuentra autorizado a realizar esta acción.",
				));
			}
		}
		if(Yii::app()->user->getState('perfil')=='Paciente'){
			$ordenUsuario = OrdenesFacturacion::model()->find("id_usuarios=? AND id_ordenes=?",array(Yii::app()->user->id,$id));
			if(!isset($ordenUsuario)){
				$this->render('/site/error',array(
					'code'=>403,
					'message'=>"Usted no se encuentra autorizado a realizar esta acción.",
				));
			}
		}
		$section = "Ordenes";
		$pagos=new Pagos('search');
		$datosFacturacion=new DatosFacturacion('search');
		$paciente =new Pacientes;
		$examenes=new Examenes('search');
		$this->render('view',array(
			'model'=>$orden,
			'paciente'=>$paciente,
			'pagos'=>$pagos,
			'datosFacturacion'=>$datosFacturacion,
			'examenes'=>$examenes,
			'ordenExamenesModel'=>$ordenExamenes,
			'ordenGruposModel'=>$ordenGrupos,
			'ordenGrupotesModel'=>$ordenGrupotes,
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
		$ordenTieneGrupos=array();
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

			$model->folio=$this->generateRandomString();

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
				$examenesIds = array_unique(split(',',$_POST['Examenes']['ids']));
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

			if(isset($_POST['Examenes']['idsGrupos']) && !empty($_POST['Examenes']['idsGrupos'])){
			$gruposIds = split(',',$_POST['Examenes']['idsGrupos']);
			}else{
				$gruposIds=array();
			}

			foreach ($gruposIds as $grupoId) {
				$ordenTieneGrupo = new OrdenTieneGrupos;
				$ordenTieneGrupo->id_grupos = $grupoId;
				$ordenTieneGrupo->ultima_edicion=$fecha_edicion;
				$ordenTieneGrupo->usuario_ultima_edicion=Yii::app()->user->id;;
				$ordenTieneGrupo->creacion=$fecha_creacion;
				$ordenTieneGrupo->usuario_creacion=Yii::app()->user->id;

				array_push($ordenTieneGrupos, $ordenTieneGrupo);
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
							$ordenTieneExamenes->usuario_creacion=Yii::app()->user->id;
							$ordenTieneExamenes->save();
						}
					}

					foreach ($ordenTieneGrupos as $ordenTieneGrupo) {
						$ordenTieneGrupo->id_ordenes = $model->id;
						$ordenTieneGrupo->save();

					}

					if(isset($paciente->id)&&$paciente->id>0){
						$paciente = Pacientes::model()->findByPk($paciente->id);
					}
					else{
						$pacienteAux = Pacientes::model()->findPacientePorNombreYFecha($paciente->nombre, $paciente->a_paterno, $paciente->a_materno, $paciente->fecha_nacimiento);
						if(isset($pacienteAux->id))
							$paciente=$pacienteAux;
						else{
							$paciente->id=null;
							$paciente->save();
						}
					}

					//GENERAR USUARIO PARA EL PACIENTE (SE GENERA UN USUARIO EN CADA ORDEN)
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

					$ordenFacturacion = new OrdenesFacturacion;
					if($model->requiere_factura==1){
						$direccion->save();
						$datosFacturacion->id_direccion=$direccion->id;
						$datosFacturacion->save();
						$ordenFacturacion->id_datos_facturacion=$datosFacturacion->id;
					}

					$ordenFacturacion->id_pacientes=$paciente->id;
					$ordenFacturacion->id_usuarios=$user->id;

					$ordenFacturacion->id_ordenes=$model->id;
					$ordenFacturacion->save();

					$pagos->id_ordenes=$model->id;
					if($totalPagado>0)
						$pagos->save();

					$model->folio= $model->folio.sprintf('%06d', $model->id);
					$model->save();

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
		$grupos=Grupos::model()->findAll("activo=1");
		$gruposTieneExamenes=array();
		foreach ($grupos as $grupo) {
			if(sizeof($grupo->grupoTiene)>0){
				$examensPorGrupo=$grupo->grupoTiene;
				$idsExemenesDelGrupo="";
				foreach ($examensPorGrupo as $examenGrupo) {
					$idsExemenesDelGrupo.=$examenGrupo->id_examenes.",";
				}
				$idsExemenesDelGrupo=substr($idsExemenesDelGrupo, 0,strlen($idsExemenesDelGrupo)-1);
				$gruposTieneExamenes[$grupo->id]=$idsExemenesDelGrupo;
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
			'examenesPorGrupo'=>$gruposTieneExamenes,
			'ordenTieneGrupos'=>$ordenTieneGrupos,
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
		$model = $this->loadModel($id);
		$ordenFacturacion = $model->ordenFacturacion;
		$paciente = $ordenFacturacion->paciente;
		$datosFacturacion = new DatosFacturacion;
		$direccion = new Direcciones;
		if ($ordenFacturacion->id_datos_facturacion!=null) {
			$datosFacturacion = $ordenFacturacion->datosFacturacion;
			$direccion = $datosFacturacion->direccion;
		}
		$examenes = new Examenes;
		$pagos = new Pagos;
		$listaTarifasExamenes = array();
		$ordenExamenes = $model->ordenTieneExamenes;
		$ordenGrupos = $model->ordenTieneGrupos;
		$ordenTieneGrupos=array();
		$examenesEncontradosIds = array();
		$examenesIds = array();
		foreach ($ordenExamenes as $ordenExamen) {
			$examen_id = $ordenExamen->detalleExamen->examenes->id;
			if (!in_array($examen_id, $examenesEncontradosIds)) {
				$tarifaActiva=TarifasActivas::model()->find('id_examenes=? AND id_multitarifarios=?', array($examen_id,$model->id_multitarifarios));
				array_push($listaTarifasExamenes, $tarifaActiva);
				array_push($examenesEncontradosIds, $examen_id);
			}
		}
		$fecha_creacion=date('Y-m-d H:i:s');
		$fecha_edicion='2000-01-01 00:00:00';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Ordenes']))
		{
			$validaRequiereFactura=true;

			$validateExamenes = true;
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$model->attributes=$_POST['Ordenes'];
				if($model->requiere_factura==1){
					$datosFacturacion->attributes=$_POST['DatosFacturacion'];
					$direccion->attributes=$_POST['Direcciones'];
					$validaRequiereFactura=($datosFacturacion->validate()&$direccion->validate());
				}
				if($model->requiere_factura==1){
					$datosFacturacion->attributes=$_POST['DatosFacturacion'];
					$direccion->attributes=$_POST['Direcciones'];
					$direccion->save();
					$datosFacturacion->id_direccion=$direccion->id;
					$datosFacturacion->save();
					$ordenFacturacion->id_datos_facturacion=$datosFacturacion->id;
					$ordenFacturacion->save();
				}
				else{
					if ($ordenFacturacion->id_datos_facturacion != null) {
						$ordenFacturacion->id_datos_facturacion = null;
						$ordenFacturacion->save();
						$datosFacturacion->delete();
						$direccion->delete();
					}
				}
				if(isset($_POST['Examenes']['ids']) && !empty($_POST['Examenes']['ids'])){
					$examenesIds = array_unique(split(',',$_POST['Examenes']['ids']));
				}else{
					$mensaje="Debe agregar al menos un examen a la orden";
					$titulo="Aviso";
					$validateExamenes=false;
				}

				$examenesCalificados=array();
				foreach ($ordenExamenes as $ordenExamen) {
					if(isset($ordenExamen->resultado))
						$examenesCalificados[$ordenExamen->id_detalles_examen]=$ordenExamen->resultado;
					$ordenExamen->delete();
				}
				foreach ($ordenGrupos as $ordenGrupo) {
					$ordenGrupo->delete();
				}

				if(isset($_POST['Examenes']['idsGrupos']) && !empty($_POST['Examenes']['idsGrupos'])){
					$gruposIds = split(',',$_POST['Examenes']['idsGrupos']);
				}else{
					$gruposIds=array();
				}

				foreach ($gruposIds as $grupoId) {
					$ordenTieneGrupo = new OrdenTieneGrupos;
					$ordenTieneGrupo->id_ordenes = $model->id;
					$ordenTieneGrupo->id_grupos = $grupoId;
					$ordenTieneGrupo->ultima_edicion=$fecha_edicion;
					$ordenTieneGrupo->usuario_ultima_edicion=Yii::app()->user->id;;
					$ordenTieneGrupo->creacion=$fecha_creacion;
					$ordenTieneGrupo->usuario_creacion=Yii::app()->user->id;

					array_push($ordenTieneGrupos, $ordenTieneGrupo);
				}


				$examenes_precio = array();
				$totalAPagar = 0;
				$ordenPrecioExamenes = $model->precios;
				foreach ($ordenPrecioExamenes as $ordenPrecio) {
					$ordenPrecio->delete();
				}
				foreach ($examenesIds as $idExamen) {
					$tarifaActiva=TarifasActivas::model()->find('id_examenes=? AND id_multitarifarios=?', array($idExamen,$model->id_multitarifarios));
					if(isset($tarifaActiva)){
						if(!in_array($tarifaActiva, $listaTarifasExamenes))
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

				if($validateExamenes && $validaRequiereFactura  && $model->save()){
					foreach ($examenes_precio as $examen_precio) {
						$examen_precio->id_ordenes = $model->id;
						$examen_precio->save();
					}

					foreach ($examenesIds as $idExamen) {
					// array_push($listaTarifasExamenes, TarifasActivas::model()->find('id_examenes=? AND id_multitarifarios=?', array($idExamen,$model->id_multitarifarios)));
						$detallesExamen = DetallesExamen::model()->findByExamenId($idExamen);
						foreach ($detallesExamen as $detalle) {
							$ordenTieneExamenes = new OrdenTieneExamenes;
							$ordenTieneExamenes->id_ordenes=$model->id;
							$ordenTieneExamenes->id_detalles_examen=$detalle->id;
							$ordenTieneExamenes->ultima_edicion=$fecha_edicion;
							$ordenTieneExamenes->usuario_ultima_edicion=Yii::app()->user->id;;
							$ordenTieneExamenes->creacion=$fecha_creacion;
							$ordenTieneExamenes->usuario_creacion=Yii::app()->user->id;
							if(isset($examenesCalificados[$detalle->id]))
								$ordenTieneExamenes->resultado=$examenesCalificados[$detalle->id];
							$ordenTieneExamenes->save();
						}
					}

					foreach ($ordenTieneGrupos as $ordenTieneGrupo) {
						$ordenTieneGrupo->save();
					}

					if(isset($model->descuento)){
						$totalAPagar=$totalAPagar * (1-($model->descuento/100));
					}
					if(isset($model->costo_emergencia)){
						$totalAPagar=$totalAPagar+$model->costo_emergencia;
					}
					$pagosAnteriores = $model->pagos;
					foreach ($pagosAnteriores as $pagoAnterior) {
						$totalAPagar-=((isset($pagoAnterior->efectivo)?$pagoAnterior->efectivo:0)+(isset($pagoAnterior->tarjeta)?$pagoAnterior->tarjeta:0)+(isset($pagoAnterior->cheque)?$pagoAnterior->cheque:0));
					}

					if (isset($_POST['Pagos'])) {
						$pagos->attributes=$_POST['Pagos'];
						$pagos->fecha=$fecha_creacion;
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
						else{
							$status=Status::model()->findByName("Creada");
						}
						$pagos->id_ordenes = $model->id;
						if($totalPagado > 0){
							$pagos->save();
						}
						$model->id_status=$status->id;
						$model->save();
					}
					$transaction->commit();
					$this->redirect(array('view','id'=>$model->id));
				}
			}catch(Exception $ex){
				$mensaje="Error inesperado";
				$titulo="Error";
			}
		}
		$grupos=Grupos::model()->findAll("activo=1");
		$gruposTieneExamenes=array();
		foreach ($grupos as $grupo) {
			$examensPorGrupo=$grupo->grupoTiene;
			$idsExemenesDelGrupo="";
			foreach ($examensPorGrupo as $examenGrupo) {
				$idsExemenesDelGrupo.=$examenGrupo->id_examenes.",";
			}
			$idsExemenesDelGrupo=substr($idsExemenesDelGrupo, 0,strlen($idsExemenesDelGrupo)-1);
			$gruposTieneExamenes[$grupo->id]=$idsExemenesDelGrupo;
		}

		if(isset($mensaje))
			$transaction->rollback();

		$this->render('update',array(
			'model'=>$model,
			'paciente'=>$paciente,
			'datosFacturacion'=>$datosFacturacion,
			'examenes'=>$examenes,
			'pagos'=>$pagos,
			'direccion' => $direccion,
			'listaTarifasExamenes'=>$listaTarifasExamenes,
			'examenesPorGrupo'=>$gruposTieneExamenes,
			'ordenTieneGrupos'=>empty($ordenTieneGrupos)?$model->ordenTieneGrupos:$ordenTieneGrupos,
			));

		$this->renderPartial('/comunes/mensaje',array('mensaje'=>isset($mensaje)?$mensaje:"",'titulo'=>isset($titulo)?$titulo:""));
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
			throw new CHttpException(404,'La página solicitada no existe.');
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
		if($orden->descuento > 0){
			$totalOrden = $totalOrden*(1-($orden->descuento/100));
		}
		if($orden->costo_emergencia > 0){
			$totalOrden= $totalOrden + $orden->costo_emergencia;
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
		$ordenGrupos = array();
		$ordenGrupotes = array();

		$ordenTieneExamenes = $model->ordenTieneExamenes;
		foreach ($ordenTieneExamenes as $ordenExamen) {
			array_push($ordenExamenes, $ordenExamen);
		}
		$ordenTieneGrupos = $model->ordenTieneGrupos;
		foreach ($ordenTieneGrupos as $ordenGrupo) {
			array_push($ordenGrupos, $ordenGrupo);
			if(GruposPerfiles::model()->count("id_grupo_padre=?",array($ordenGrupo->id_grupos))>0){
				array_push($ordenGrupotes,$ordenGrupo->grupo);
			}
		}
		if(isset($_POST['Ordenes'])){
			$model->comentarios_resultados=$_POST['Ordenes']['comentarios_resultados'];
		}
		if (isset($_POST['OrdenTieneExamenes'])) {
			$calificada = true;
			
			foreach ($_POST['OrdenTieneExamenes'] as $i => $value) {
				
				$ordenExamenToSave = OrdenTieneExamenes::model()->findByPk($i);
				$ordenExamenToSave->resultado = $value['resultado'];
				$ordenExamenToSave->save();
				if ($calificada) {
					$calificada = $ordenExamenToSave->resultado!="";
				}
			}
			foreach ($_POST['comentario_perfil'] as $i => $value) {
				echo $value."<br />";
				//continue;
				$ordenGrupoToSave = OrdenTieneGrupos::model()->find("id_ordenes=? AND id_grupos=?",array($id,$i));
				print_r($ordenGrupoToSave);
				continue;
				$ordenGrupoToSave->comentarios_perfil = $value;
				$ordenGrupoToSave->save();
			}
			return;
			$statusPagada=Status::model()->findByName("Pagada");
			$statusCalificada=Status::model()->findByName("Calificada");
			$statusFinalizada=Status::model()->findByName("Finalizada");
			$statusCreada=Status::model()->findByName("Creada");

			if($model->id_status == $statusPagada->id && $calificada){
				$model->id_status = $statusFinalizada->id;

			}
			elseif (!$calificada && $model->id_status == $statusFinalizada->id) {
				$model->id_status = $statusPagada->id;

			}
			elseif ($calificada && $model->id_status == $statusCreada->id) {
				$model->id_status = $statusCalificada->id;

			}
			$model->save();
			$this->redirect(array('view','id'=>$model->id));
		}
		$this->render('_calificar',array(
			'model'=>$model,
			'ordenExamenesModel'=>$ordenExamenes,
			'ordenGruposModel'=>$ordenGrupos,
			'ordenGrupotesModel'=>$ordenGrupotes,

			));
	}

	public function actionAgregarExamen(){
		//print_r($_POST);
		$examen=Examenes::model()->findByPk($_POST['id']);
		$tarifa=TarifasActivas::model()->find('id_examenes=? AND id_multitarifarios=?',array($_POST['id'],$_POST['tarifa']));
		$precio=isset($tarifa->precio)?$tarifa->precio:0;
		$precioText=isset($tarifa->precio)?'$ '.$tarifa->precio:'No hay precio para el tarifario seleccionado';
		$agregarPrecio = isset($tarifa->precio)?"":"<a href='javascript:void(0)' data-id='$examen->id' class='btn default blue-stripe agregarPrecio' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;'>Agregar precio</a><input type='text' class='form-control input-small' id='addPrecio_$examen->id' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;' />";
		$tienePrecio=strlen($agregarPrecio)>0?"true":"false";
		echo "<tr class='row_$examen->id' data-id='$examen->id'>
		<td>$examen->clave</td>
		<td>$examen->nombre</td>
		<td class='precioExamen' data-val='$precio'>$precioText $agregarPrecio</td>
		<td><a href='javascript:void(0)' data-tienePrecio='$tienePrecio' data-id='$examen->id' class='eliminarExamen'><span class='fa fa-trash'></span></a></td>
		</tr>";
	}

	public function actionAgregarGrupoExamen(){
		//print_r($_POST);
		$idsExamenes = split(",", $_POST['idsExamenes']);
		$grupo=Grupos::model()->findByPk($_POST['id']);
		$sumaPrecios=0;
		$idsExamenesGrupos="";
		$agregoGrupo=false;
		foreach ($grupo->grupoTiene as $tiene) {
			$examen=$tiene->examen;
			if($examen->activo==1 && sizeof($examen->detallesExamenes)>0 && $examen->tieneResultadosActivos() && !in_array($examen->id, $idsExamenes)){
				$tarifa=TarifasActivas::model()->find('id_examenes=? AND id_multitarifarios=?',array($examen->id,$_POST['tarifa']));
				$precio=isset($tarifa->precio)?$tarifa->precio:0;
				$sumaPrecios+=$precio;
				$idsExamenesGrupos.=$examen->id.",";
				$agregoGrupo=true;
				//$precioText=isset($tarifa->precio)?"$ ".$tarifa->precio:'No hay precio para el tarifario seleccionado';
				//$agregarPrecio = isset($tarifa->precio)?"":"<a href='javascript:void(0)' data-id='$examen->id' class='btn default blue-stripe agregarPrecio' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;'>Agregar precio</a><input type='text' class='form-control input-small' id='addPrecio_$examen->id' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;' />";
			}
		}
		if($agregoGrupo){
			$idsExamenesGrupos = substr($idsExamenesGrupos, 0, strlen($idsExamenesGrupos)-1);
			echo "<tr class='row_grupo_$grupo->id' data-id='$grupo->id'>
				<td>$grupo->clave</td>
				<td>$grupo->nombre</td>
				<td class='precioExamen' data-val='$sumaPrecios'>$ $sumaPrecios</td>
				<td><a href='javascript:void(0)' data-id='$idsExamenesGrupos' data-idgrupo='$grupo->id' class='eliminarGrupo'><span class='fa fa-trash'></span></a></td>
				</tr>";
		}

	}

	public function actionActualizarPrecios(){
		$examenes=split(',',$_POST['examenes']);
		$grupos=split(',',$_POST['grupos']);
		$tarifario = $_POST['tarifa'];

		$examenesAgregados=array();
		for($i=0; $i<sizeof($grupos)&&strlen($grupos[$i])>0; $i++){
			$precio=0;
			$grupo=Grupos::model()->findByPk($grupos[$i]);
			$cadenaIdsExamenesGrupo="";
			foreach ($grupo->grupoTiene as $grupoExamenes) {
				$tarifa=TarifasActivas::model()->find('id_examenes=? AND id_multitarifarios=?',array($grupoExamenes->id_examenes,$tarifario));
				$cadenaIdsExamenesGrupo.=$grupoExamenes->id_examenes.",";

				if(isset($tarifa)&&!in_array($grupoExamenes->id_examenes, $examenesAgregados)){
					$precio+=$tarifa->precio;
					array_push($examenesAgregados, $grupoExamenes->id_examenes);
				}

			}
			$cadenaIdsExamenesGrupo=substr($cadenaIdsExamenesGrupo, 0, strlen($cadenaIdsExamenesGrupo)-1);

			$precioText="$ ".$precio;
			echo "<tr class='row_grupo_$grupo->id' data-id='$grupo->id'>
			<td>$grupo->clave</td>
			<td>$grupo->nombre</td>
			<td class='precioExamen' data-val='$precio'>$precioText</td>
			<td><a href='javascript:void(0)' data-id='$cadenaIdsExamenesGrupo' data-idgrupo='$grupo->id' class='eliminarGrupo'><span class='fa fa-trash'></span></a></td>


			</tr>";

		}

		for ($i=0; $i<sizeof($examenes); $i++) {
			if(!in_array($examenes[$i], $examenesAgregados)){
				$examen=Examenes::model()->findByPk($examenes[$i]);
				if(sizeof($examen->detallesExamenes)>0 && $examen->tieneResultadosActivos()){
					$tarifa=TarifasActivas::model()->find('id_examenes=? AND id_multitarifarios=?',array($examenes[$i],$tarifario));
					$precio=isset($tarifa->precio)?$tarifa->precio:0;
					$precioText=isset($tarifa->precio)?"$ ".$tarifa->precio:'No hay precio para el tarifario seleccionado';
					$agregarPrecio = isset($tarifa->precio)?"":"<a href='javascript:void(0)' data-id='$examen->id' class='btn default blue-stripe agregarPrecio' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;'>Agregar precio</a><input type='text' class='form-control input-small' id='addPrecio_$examen->id' style='float:right; height:20px; padding:0px; padding-left:5px; padding-right:5px;' />";
					$tienePrecio=strlen($agregarPrecio)>0?"true":"false";
					echo "<tr class='row_$examen->id' data-id='$examen->id'>
					<td>$examen->clave</td>
					<td>$examen->nombre</td>
					<td class='precioExamen' data-val='$precio'>$precioText $agregarPrecio</td>
					<td><a href='javascript:void(0)' data-tienePrecio='$tienePrecio' data-id='$examen->id' class='eliminarExamen'><span class='fa fa-trash'></span></a></td>
					</tr>";
					array_push($examenesAgregados, $examen->id);
				}
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
		<td><a href='javascript:void(0)' data-id='$examen->id' class='eliminarExamen'><span class='fa fa-trash'></span></a></td>
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

	public function actionGenerarPdf($id){
		$model = $this->loadModel($id);
		$pdf = new ImprimirOrden('P','cm','letter');
		$pdf->AddPage();
		$pdf->cabeceraHorizontal($model);
		$pdf->contenido($model);
		$pdf->Output();
	}

	public function actionImprimirResultadosPdf($id){
		$model = $this->loadModel($id);
		$pdf = new ImprimirResultados('P','cm','letter');
		$pdf->AddPage();
		$pdf->model = $model;
		//$pdf->cabeceraHorizontal($model);
		$pdf->contenido($model);
		$pdf->Output();
	}

	public function actionImprimirResultadosArchivo($id){
		$model = $this->loadModel($id);
		$pdf = new ImprimirResultadosArchivo('P','cm','letter');
		$pdf->AddPage();
		$pdf->model = $model;
		//$pdf->cabeceraHorizontal($model);
		$pdf->contenido($model);
		$pdf->Output();
	}

	public function actionGruposPorExamen(){
		$grupos =  GrupoExamenes::model()->findAll('id_examenes=?',array($_POST['id']));
		$grupo = $grupos[0];
		$ids = "".$grupo->id_grupos_examenes;
		foreach($grupos as $index=>$grupo){
			if($index>0){
			$ids .= ",".$grupo->id_grupos_examenes;
			}
		}

		echo $ids;
	}

	function generateRandomString($length = 6) {
	    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}
}
