<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $usuario;
	public $contrasena;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('usuario, contrasena', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('contrasena', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>'Recordarme',
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->usuario,$this->contrasena);
			if($this->isActivo()){
				if(!$this->_identity->authenticate())
					$this->addError('contrasena','Usuario o contraseña incorrectos.');
			}
			else{
				$this->addError('usuario','El usuario esta inactivo');
			}
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{	
			
			$this->_identity=new UserIdentity($this->usuario,$this->contrasena);
			if($this->isActivo()){
				$this->_identity->authenticate();
			}
			else{
				return false;
			}
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}

	public function isActivo(){
		$user = Usuarios::model()->find('usuario=?',array($this->usuario));
		if (isset($user)) {
			$doctor=Doctores::model()->find('id_usuarios=?',array($user->id));
			if(isset($doctor)&&$doctor->activo==1)
				return true;

			$ordenFacturacion=OrdenesFacturacion::model()->find('id_usuarios=?',array($user->id));
			if (isset($ordenFacturacion)) {
				$paciente = $ordenFacturacion->paciente;
			}
			if(isset($paciente)&&$paciente->activo==1)
				return true;

			if($user->perfil->nombre=="Administrador")
				return true;

			if($user->perfil->nombre=="Basico")
				return true;

			if($user->perfil->nombre=="Quimico")
				return true;

			return false;	
		}
		else{
			return true;
		}
		
	}
}
