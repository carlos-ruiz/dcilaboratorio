<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class FacturacionForm extends CFormModel
{
	public $numeroFactura;
	public $razon_social;
	public $rfc;
	public $calle;
	public $numero;
	public $colonia;
	public $codigo_postal;
	public $localidad;
	public $municipio;
	public $estado;
	public $fecha;
	public $conceptos;
	public $descuento;
	public $costo_extra;
	public $id_orden;
	public $csd_emisor;
	public $correo_electronico;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('razon_social, rfc, calle, numero, colonia, codigo_postal, localidad, municipio, estado, fecha, conceptos', 'required'),
			// numerical
			array('costo_extra', 'length', 'max'=>8),
			array('numero', 'length', 'max'=>10),
			array('descuento', 'numerical', 'integerOnly'=>true, 'min'=>0, 'max'=>100),
			array('correo_electronico', 'email'),
			//validate RFC
			// array('rfc', 'match', 'pattern' => '^([A-ZÑ\x26]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])[A-Z|\d]{3})$', 'message' => 'El RFC es inválido.');
			array('rfc', 'match', 'pattern' => '^([a-zA-Z&Ññ]{3}|[a-zA-Z][aAeEiIoOuU][a-zA-Z]{2})\\d{2}((01|03|05|07|08|10|12)(0[1-9]|[12]\\d|3[01])|02(0[1-9]|[12]\\d)|(04|06|09|11)(0[1-9]|[12]\\d|30))([a-zA-Z0-9]{2}[0-9aA])$^', 'message' => 'El RFC es inválido.'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'razon_social'=>'Razón social',
			'rfc'=>'RFC',
			'calle'=>'Calle',
			'numero'=>'Número',
			'colonia'=>'Colonia',
			'codigo_postal'=>'Código postal',
			'localidad'=>'Localidad/Ciudad',
			'municipio'=>'Municipio',
			'estado'=>'Estado',
			'fecha'=>'Fecha de emisión',
			'conceptos'=>'Conceptos',
			'descuento'=>'Descuento',
			'costo_extra'=>'Costo de emergencia',
			'numeroFactura'=>"Factura número",
			'correo_electronico'=>"Correo electrónico",
		);
	}
}
