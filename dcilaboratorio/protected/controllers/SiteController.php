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
			//$perfil->edicion=date('Y-m-d H:i:s');
			//$perfil->usuario_edicion=0;
			//$perfil->creacion=date('Y-m-d H:i:s');
			//$perfil->usuario_creacion=0;
		}
		else{
			$perfil=Perfiles::model()->findByName("Administrador");
		}

		if(Usuarios::model()->count()==0){
			$nuevoUsuario = new Usuarios;
			$nuevoUsuario->usuario="admin";
			$nuevoUsuario->contrasena=md5("admin");
			$nuevoUsuario->ultima_edicion=date('Y-m-d H:i:s');
			$nuevoUsuario->usuario_ultima_edicion=0;
			$nuevoUsuario->creacion=date('Y-m-d H:i:s');
			$nuevoUsuario->usuario_creacion=0;
			$nuevoUsuario->id_perfiles=$perfil->id;
			$nuevoUsuario->save();
		}
	}

}