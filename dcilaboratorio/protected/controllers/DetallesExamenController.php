<?php

class DetallesExamenController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $section = "Examenes";
	public $subSection;
	public $pageTitle="Configura test";
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
				'actions'=>array('index','view','create','update','admin','delete', 'obtenerTipoExamen'),
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
		$this->subSection = "Grupos";
		$model=new DetallesExamen;
		$model->genero='Indistinto';
		$model->tipo='Normal';
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DetallesExamen']))
		{

			$model->attributes=$_POST['DetallesExamen'];
			if(isset($_POST['DetallesExamen']['multirangos']))
				$model->multirangos=$_POST['DetallesExamen']['multirangos'];
			if(isset($_POST['DetallesExamen']['concentracion']))
				$model->concentracion=$_POST['DetallesExamen']['concentracion'];
			if (!isset($model->tipo) || strlen($model->tipo)<1) {
				$examen = Examenes::model()->findByPk($model->id_examenes);
				$model->tipo = $examen->detallesExamenes[0]->tipo;
			}
			if($model->save()){
				if($model->tipo == 'Multirango'){
					foreach ($model->multirangos as $multirangoSeleccionado) {
						$detalleTieneMultirango = new DetallesExamenTieneMultirangos;
						$detalleTieneMultirango->id_detalles_examen=$model->id;
						$detalleTieneMultirango->id_multirangos=$multirangoSeleccionado;
						$detalleTieneMultirango->save();
					}
				}
				$this->redirect(array('view','id'=>$model->id));
			}
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
		$model->multirangos=array();
		$multirangosAnteriores=DetallesExamenTieneMultirangos::model()->findAll('id_detalles_examen=?',array($id));
		foreach ($multirangosAnteriores as $multirango) {
			array_push($model->multirangos, $multirango->id_multirangos);
		}
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		$tipo=$model->tipo;
		if(isset($_POST['DetallesExamen']))
		{
			$model->attributes=$_POST['DetallesExamen'];
			$model->tipo=$tipo;
			if(isset($_POST['DetallesExamen']['multirangos']))
				$model->multirangos=$_POST['DetallesExamen']['multirangos'];
			if(isset($_POST['DetallesExamen']['concentracion']))
				$model->concentracion=$_POST['DetallesExamen']['concentracion'];
			if($model->save()){
				DetallesExamenTieneMultirangos::model()->deleteAll('id_detalles_examen=?',array($id));
				if($model->tipo == 'Multirango'){
					foreach ($model->multirangos as $multirangoSeleccionado) {
						$detalleTieneMultirango = new DetallesExamenTieneMultirangos;
						$detalleTieneMultirango->id_detalles_examen=$model->id;
						$detalleTieneMultirango->id_multirangos=$multirangoSeleccionado;
						$detalleTieneMultirango->save();
					}
				}
				$this->redirect(array('view','id'=>$model->id));
			}
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
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$this->subSection = "Resultados";
		$model=new DetallesExamen('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DetallesExamen']))
			$model->attributes=$_GET['DetallesExamen'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return DetallesExamen the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=DetallesExamen::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'La página solicitada no existe.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param DetallesExamen $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='detalles-examen-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	public function actionObtenerTipoExamen()
	{
		$idExamen = $_POST['DetallesExamen']['id_examenes'];
		$examen = Examenes::model()->findByPk($idExamen);
		$tipo = 'ninguno';
		if (isset($examen) && isset($examen->detallesExamenes[0])) {
			$tipo = $examen->detallesExamenes[0]->tipo;
		}
		echo $tipo;
	}
}
