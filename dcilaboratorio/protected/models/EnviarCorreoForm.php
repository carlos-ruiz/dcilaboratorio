<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class EnviarCorreoForm extends CFormModel
{
	public $email;
	public $resultados_archivo;
	public $comentarios;



	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('email', 'required'),
			array('email', 'email'),
			array('comentarios, resultados_archivo', 'safe'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email'=>'Correo electrónico',
			'resultados_archivo'=>'¿Enviar resultados de archivo?',
			'comentarios'=>'Comentarios',
		);
	}

}
