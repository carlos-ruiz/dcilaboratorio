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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','view','create','update','admin','delete'),
				'users'=>array_merge(Usuarios::model()->obtenerPorPerfil('Administrador'), Usuarios::model()->obtenerPorPerfil('Quimico')),
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
		$model->examenes=array();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Grupos']))
		{


			$model->attributes=$_POST['Grupos'];
			$model->attributes=$_POST['Grupos'];
			if(isset($_POST['Grupos']["examenes"]))
				$model->examenes=$_POST['Grupos']["examenes"];
			if(isset($_POST['Grupos']["grupos"]))
				$model->grupos=$_POST['Grupos']["grupos"];

			if($model->save()){
				$examenesGuardados=array();
				$error=false;
				for($i=0;$i<sizeof($model->examenes);$i++){
					$grupoExamenes = new GrupoExamenes;
					$grupoExamenes->id_examenes=$model->examenes[$i];
					$grupoExamenes->id_grupos_examenes = $model->id;
					$grupoExamenes->ultima_edicion = $model->ultima_edicion;
					$grupoExamenes->usuario_ultima_edicion = $model->usuario_ultima_edicion;
					$grupoExamenes->creacion = $model->creacion;
					$grupoExamenes->usuario_creacion = $model->usuario_creacion;
					if(!$grupoExamenes->save()){
						$error=true;
					}else{array_push($examenesGuardados,$model->examenes[$i]);}
				}

				for($i=0;$i<sizeof($model->grupos);$i++){
					$gpo = Grupos::model()->find("id=?",array($model->grupos[$i]));
					$gpoPerfiles=new GruposPerfiles;
					$gpoPerfiles->id_grupo_padre=$model->id;
					$gpoPerfiles->id_grupo_hijo=$model->grupos[$i];
					$gpoPerfiles->ultima_edicion = $model->ultima_edicion;
					$gpoPerfiles->usuario_ultima_edicion = $model->usuario_ultima_edicion;
					$gpoPerfiles->creacion = $model->creacion;
					$gpoPerfiles->usuario_creacion = $model->usuario_creacion;
					$gpoPerfiles->save();
					foreach ($gpo->grupoTiene as $exam) {
						if(!in_array($exam->id_examenes,$examenesGuardados)){
							$grupoExamenes = new GrupoExamenes;
							$grupoExamenes->id_examenes=$exam->id_examenes;
							$grupoExamenes->id_grupos_examenes = $model->id;
							$grupoExamenes->ultima_edicion = $model->ultima_edicion;
							$grupoExamenes->usuario_ultima_edicion = $model->usuario_ultima_edicion;
							$grupoExamenes->creacion = $model->creacion;
							$grupoExamenes->usuario_creacion = $model->usuario_creacion;
							if(!$grupoExamenes->save()){
								$error=true;
							}else{array_push($examenesGuardados,$exam->id_examenes);}
						}
					}

				}
				if(!$error)
					$this->redirect(array('admin'));

			}
		}

		$this->render('create',array(
			'model'=>$model,
			'examenes'=>$examenes,

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
		$examenesEnGrupos=array();

		$gruposForGrupo=GruposPerfiles::model()->findGruposForGrupo($id);
		if(sizeof($gruposForGrupo)>0)
			$model->esPerfilote=1;
		$model->grupos=array();
		foreach ($gruposForGrupo as $grupo) {
			array_push($model->grupos, $grupo->id_grupo_hijo);
			foreach ($grupo->idGrupoHijo->grupoTiene as $grupoExamen) {
				array_push($examenesEnGrupos, $grupoExamen->id_examenes);
			}
		}

		$examenesForGrupo=GrupoExamenes::model()->findExamenesForGrupo($id);
		$model->examenes=array();
		foreach ($examenesForGrupo as $examen) {
			if(!in_array($examen->id, $examenesEnGrupos))
				array_push($model->examenes, $examen->id);
		}



		//$model->grupos=$_POST['Grupos']["grupos"];

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Grupos']))
		{
			$transaction = Yii::app()->db->beginTransaction();
			try{
				//Eliminamos valore antiguos del perfil
				GruposPerfiles::model()->deleteAll("id_grupo_padre=?",array($model->id));
				GrupoExamenes::model()->deleteAll("id_grupos_examenes=?",array($model->id));

				$model->attributes=$_POST['Grupos'];
				if(isset($_POST['Grupos']["examenes"]))
					$model->examenes=$_POST['Grupos']["examenes"];
				else
					$model->examenes=array();
				if(isset($_POST['Grupos']["grupos"]))
					$model->grupos=$_POST['Grupos']["grupos"];
				else
					$model->grupos=array();
				if(sizeof($model->grupos)==0&&sizeof($model->examenes)==0){
					$this->render('update',array(
						'model'=>$model,
						'examenes'=>$examenes,

					));
					$this->renderPartial('/comunes/mensaje',array('titulo'=>'Error','mensaje'=>'Debes seleccionar al menos una determinación o perfil'));
					return;
				}

				if($model->save()){
					$examenesGuardados=array();
					$error=false;
					for($i=0;$i<sizeof($model->examenes);$i++){
						$grupoExamenes = new GrupoExamenes;
						$grupoExamenes->id_examenes=$model->examenes[$i];
						$grupoExamenes->id_grupos_examenes = $model->id;
						$grupoExamenes->ultima_edicion = $model->ultima_edicion;
						$grupoExamenes->usuario_ultima_edicion = $model->usuario_ultima_edicion;
						$grupoExamenes->creacion = $model->creacion;
						$grupoExamenes->usuario_creacion = $model->usuario_creacion;
						if(!$grupoExamenes->save()){
							$error=true;
						}else{array_push($examenesGuardados,$model->examenes[$i]);}
					}

					GruposPerfiles::model()->deleteAll('id_grupo_padre=?',array($model->id));

					if(sizeof($model->grupos)>0&&$_POST['Grupos']["esPerfilote"]==1){
						$model->esPerfilote=1;
						for($i=0;$i<sizeof($model->grupos);$i++){
							$gpo = Grupos::model()->find("id=?",array($model->grupos[$i]));
							$gpoPerfiles=new GruposPerfiles;
							$gpoPerfiles->id_grupo_padre=$model->id;
							$gpoPerfiles->id_grupo_hijo=$model->grupos[$i];
							$gpoPerfiles->ultima_edicion = $model->ultima_edicion;
							$gpoPerfiles->usuario_ultima_edicion = $model->usuario_ultima_edicion;
							$gpoPerfiles->creacion = $model->creacion;
							$gpoPerfiles->usuario_creacion = $model->usuario_creacion;
							$gpoPerfiles->save();
							foreach ($gpo->grupoTiene as $exam) {
								if(!in_array($exam->id_examenes,$examenesGuardados)){
									$grupoExamenes = new GrupoExamenes;
									$grupoExamenes->id_examenes=$exam->id_examenes;
									$grupoExamenes->id_grupos_examenes = $model->id;
									$grupoExamenes->ultima_edicion = $model->ultima_edicion;
									$grupoExamenes->usuario_ultima_edicion = $model->usuario_ultima_edicion;
									$grupoExamenes->creacion = $model->creacion;
									$grupoExamenes->usuario_creacion = $model->usuario_creacion;
									if(!$grupoExamenes->save()){
										$error=true;
									}else{array_push($examenesGuardados,$exam->id_examenes);}
								}
							}
						}
					}else{
						$model->esPerfilote=0;
					}
					if(!$error){
						$transaction->commit();
						$this->redirect(array('admin'));

					}
					else{
						$transaction->rollback();
					}
				}
			}catch(Exception $ex){
				$transaction->rollback();
			}

		}

		$this->render('update',array(
			'model'=>$model,
			'examenes'=>$examenes,

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
			throw new CHttpException(404,'La página solicitada no existe.');
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

