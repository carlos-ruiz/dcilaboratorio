<?php

/**
 * This is the model class for table "facturas_expedidas".
 *
 * The followings are the available columns in table 'facturas_expedidas':
 * @property integer $id
 * @property string $razon_social
 * @property string $rfc
 * @property string $calle
 * @property string $numero
 * @property string $colonia
 * @property string $codigo_postal
 * @property string $localidad
 * @property string $municipio
 * @property string $estado
 * @property string $fecha_emision
 * @property string $fecha_certificacion
 * @property string $uuid
 * @property string $numero_comprobante
 * @property string $cadena_original
 * @property string $sello_cfdi
 * @property string $sello_sat
 * @property integer $id_ordenes
 *
 * The followings are the available model relations:
 * @property ConceptosFactura[] $conceptosFacturas
 * @property Ordenes $idOrdenes
 */
class FacturasExpedidas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'facturas_expedidas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('razon_social, rfc, calle, numero, colonia, codigo_postal, localidad, municipio, estado, fecha_emision, fecha_certificacion, uuid, numero_comprobante, cadena_original, sello_cfdi, sello_sat', 'required'),
			array('id_ordenes', 'numerical', 'integerOnly'=>true),
			array('razon_social, cadena_original, sello_cfdi, sello_sat', 'length', 'max'=>500),
			array('rfc', 'length', 'max'=>13),
			array('calle, colonia, localidad', 'length', 'max'=>200),
			array('numero', 'length', 'max'=>10),
			array('codigo_postal', 'length', 'max'=>5),
			array('municipio, estado, uuid, numero_comprobante', 'length', 'max'=>45),
			array('rfc', 'match', 'pattern' => '^([a-zA-Z&Ññ]{3}|[a-zA-Z][aAeEiIoOuU][a-zA-Z]{2})\\d{2}((01|03|05|07|08|10|12)(0[1-9]|[12]\\d|3[01])|02(0[1-9]|[12]\\d)|(04|06|09|11)(0[1-9]|[12]\\d|30))([a-zA-Z0-9]{2}[0-9aA])$^', 'message' => 'El RFC es inválido.'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, razon_social, rfc, calle, numero, colonia, codigo_postal, localidad, municipio, estado, fecha_emision, fecha_certificacion, uuid, numero_comprobante, cadena_original, sello_cfdi, sello_sat, id_ordenes', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'conceptos' => array(self::HAS_MANY, 'ConceptosFactura', 'id_facturas_expedidas'),
			'orden' => array(self::BELONGS_TO, 'Ordenes', 'id_ordenes'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'razon_social' => 'Razón Social',
			'rfc' => 'RFC',
			'calle' => 'Calle',
			'numero' => 'Número',
			'colonia' => 'Colonia',
			'codigo_postal' => 'Código Postal',
			'localidad' => 'Localidad',
			'municipio' => 'Municipio',
			'estado' => 'Estado',
			'fecha_emision' => 'Fecha Emisión',
			'fecha_certificacion' => 'Fecha Certificación',
			'uuid' => 'UUID',
			'numero_comprobante' => 'Número Comprobante',
			'cadena_original' => 'Cadena Original',
			'sello_cfdi' => 'Sello CFDI',
			'sello_sat' => 'Sello SAT',
			'id_ordenes' => 'Órdenes',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('razon_social',$this->razon_social,true);
		$criteria->compare('rfc',$this->rfc,true);
		$criteria->compare('calle',$this->calle,true);
		$criteria->compare('numero',$this->numero,true);
		$criteria->compare('colonia',$this->colonia,true);
		$criteria->compare('codigo_postal',$this->codigo_postal,true);
		$criteria->compare('localidad',$this->localidad,true);
		$criteria->compare('municipio',$this->municipio,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('fecha_emision',$this->fecha_emision,true);
		$criteria->compare('fecha_certificacion',$this->fecha_certificacion,true);
		$criteria->compare('uuid',$this->uuid,true);
		$criteria->compare('numero_comprobante',$this->numero_comprobante,true);
		$criteria->compare('cadena_original',$this->cadena_original,true);
		$criteria->compare('sello_cfdi',$this->sello_cfdi,true);
		$criteria->compare('sello_sat',$this->sello_sat,true);
		$criteria->compare('id_ordenes',$this->id_ordenes);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return FacturasExpedidas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
