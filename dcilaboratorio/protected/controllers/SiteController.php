<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public $section = "Home";
	public $subSection;

	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */

	public function actionLoadModalContent(){
		$this->renderPartial("_modalContent");
	}

	public function actionIndex()
	{
		//Para inicializar el sistema
		$this->init();

		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		//$this->render('index');
		if(Yii::app()->user->isGuest)
			$this->layout='//layouts/loginForm';
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('index',array('model'=>$model));
		
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if(Yii::app()->user->isGuest)
			$this->layout='//layouts/loginForm';
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		if(Yii::app()->user->isGuest)
			$this->layout='//layouts/loginForm';
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if(Yii::app()->user->isGuest)
			$this->layout='//layouts/loginForm';
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		if(Yii::app()->user->isGuest)
			$this->layout='//layouts/loginForm';
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function init(){
		if(Perfiles::model()->count()==0){
			$perfil = new Perfiles;
			$perfil->nombre="Administrador";
			$perfil->save();
			$perfil2 = new Perfiles;
			$perfil2->nombre="Paciente";
			$perfil2->save();

		}
		else{
			$perfil=Perfiles::model()->findByName("Administrador");
		}

		if(Status::model()->count()==0){
			$status = new Status;
			$status->nombre="Creada";
			$status->descripcion="Creada";
			$status->ultima_edicion=date('2000-01-01 00:00:00');
			$status->usuario_ultima_edicion=0;
			$status->creacion=date('Y-m-d H:i:s');
			$status->usuario_creacion=0;
			$status->save();
			$status2 = new Status;
			$status2->nombre="Pagada";
			$status2->descripcion="Pagada";
			$status2->ultima_edicion=date('2000-01-01 00:00:00');
			$status2->usuario_ultima_edicion=0;
			$status2->creacion=date('Y-m-d H:i:s');
			$status2->usuario_creacion=0;
			$status2->save();
			$status3 = new Status;
			$status3->nombre="Calificada";
			$status3->descripcion="Calificada";
			$status3->ultima_edicion=date('2000-01-01 00:00:00');
			$status3->usuario_ultima_edicion=0;
			$status3->creacion=date('Y-m-d H:i:s');
			$status3->usuario_creacion=0;
			$status3->save();
			$status3 = new Status;
			$status3->nombre="Finalizada";
			$status3->descripcion="Finalizada";
			$status3->ultima_edicion=date('2000-01-01 00:00:00');
			$status3->usuario_ultima_edicion=0;
			$status3->creacion=date('Y-m-d H:i:s');
			$status3->usuario_creacion=0;
			$status3->save();
		}

		if(Usuarios::model()->count()==0){
			$nuevoUsuario = new Usuarios;
			$nuevoUsuario->usuario="admin";
			$nuevoUsuario->contrasena=base64_encode("admin");
			$nuevoUsuario->ultima_edicion=date('Y-m-d H:i:s');
			$nuevoUsuario->usuario_ultima_edicion=0;
			$nuevoUsuario->creacion=date('Y-m-d H:i:s');
			$nuevoUsuario->usuario_creacion=0;
			$nuevoUsuario->id_perfiles=$perfil->id;
			$nuevoUsuario->save();
		}

		if (TitulosForm::model()->count()==0) {
			$dr = new TitulosForm;
			$dr->nombre = "Dr.";
			$dr->ultima_edicion=date('Y-m-d H:i:s');
			$dr->usuario_ultima_edicion=0;
			$dr->creacion=date('Y-m-d H:i:s');
			$dr->usuario_creacion=0;
			$dr->save();

			$dra = new TitulosForm;
			$dra->nombre = "Dra.";
			$dra->ultima_edicion=date('Y-m-d H:i:s');
			$dra->usuario_ultima_edicion=0;
			$dra->creacion=date('Y-m-d H:i:s');
			$dra->usuario_creacion=0;
			$dra->save();

			$sr = new TitulosForm;
			$sr->nombre = "Sr.";
			$sr->ultima_edicion=date('Y-m-d H:i:s');
			$sr->usuario_ultima_edicion=0;
			$sr->creacion=date('Y-m-d H:i:s');
			$sr->usuario_creacion=0;
			$sr->save();

			$sra = new TitulosForm;
			$sra->nombre = "Sra.";
			$sra->ultima_edicion=date('Y-m-d H:i:s');
			$sra->usuario_ultima_edicion=0;
			$sra->creacion=date('Y-m-d H:i:s');
			$sra->usuario_creacion=0;
			$sra->save();

			$srita = new TitulosForm;
			$srita->nombre = "Srita.";
			$srita->ultima_edicion=date('Y-m-d H:i:s');
			$srita->usuario_ultima_edicion=0;
			$srita->creacion=date('Y-m-d H:i:s');
			$srita->usuario_creacion=0;
			$srita->save();

			$quimico = new TitulosForm;
			$quimico->nombre = "Químico";
			$quimico->ultima_edicion=date('Y-m-d H:i:s');
			$quimico->usuario_ultima_edicion=0;
			$quimico->creacion=date('Y-m-d H:i:s');
			$quimico->usuario_creacion=0;
			$quimico->save();

			$quimica = new TitulosForm;
			$quimica->nombre = "Química";
			$quimica->ultima_edicion=date('Y-m-d H:i:s');
			$quimica->usuario_ultima_edicion=0;
			$quimica->creacion=date('Y-m-d H:i:s');
			$quimica->usuario_creacion=0;
			$quimica->save();
		}

		if (TiposContacto::model()->count()==0) {
			$casa = new TiposContacto;
			$casa->descripcion = "Casa";
			$casa->abreviatura = "Casa";
			$casa->ultima_edicion=date('Y-m-d H:i:s');
			$casa->usuario_ultima_edicion=0;
			$casa->creacion=date('Y-m-d H:i:s');
			$casa->usuario_creacion=0;
			$casa->save();

			$consultorio = new TiposContacto;
			$consultorio->descripcion = "Consultorio";
			$consultorio->abreviatura = "Consultorio";
			$consultorio->ultima_edicion=date('Y-m-d H:i:s');
			$consultorio->usuario_ultima_edicion=0;
			$consultorio->creacion=date('Y-m-d H:i:s');
			$consultorio->usuario_creacion=0;
			$consultorio->save();

			$celular = new TiposContacto;
			$celular->descripcion = "Celular";
			$celular->abreviatura = "Cel.";
			$celular->ultima_edicion=date('Y-m-d H:i:s');
			$celular->usuario_ultima_edicion=0;
			$celular->creacion=date('Y-m-d H:i:s');
			$celular->usuario_creacion=0;
			$celular->save();

			$correo = new TiposContacto;
			$correo->descripcion = "Correo electrónico";
			$correo->abreviatura = "Correo";
			$correo->ultima_edicion=date('Y-m-d H:i:s');
			$correo->usuario_ultima_edicion=0;
			$correo->creacion=date('Y-m-d H:i:s');
			$correo->usuario_creacion=0;
			$correo->save();
		}
	}

}