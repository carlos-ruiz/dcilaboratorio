<?php

/**
 * This is the model class for table "datos_facturacion".
 *
 * The followings are the available columns in table 'datos_facturacion':
 * @property integer $id
 * @property string $razon_social
 * @property string $RFC
 * @property string $calle
 * @property string $num_ext
 * @property string $num_int
 * @property string $colonia
 * @property string $ciudad
 * @property string $municipio
 * @property string $estado
 * @property string $codigo_postal
 * @property integer $id_pacientes
 *
 * The followings are the available model relations:
 * @property Pacientes $idPacientes
 */
class DatosFacturacion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'datos_facturacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, id_pacientes, RFC, razon_social, calle, num_ext, colonia, ciudad, municipio, estado', 'required'),
			array('id, id_pacientes', 'numerical', 'integerOnly'=>true),
			array('razon_social', 'length', 'max'=>500),
			array('RFC', 'length', 'max'=>13),
			array('calle, num_ext, num_int, colonia, ciudad, municipio, estado', 'length', 'max'=>45),
			array('codigo_postal', 'length', 'max'=>5),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, razon_social, RFC, calle, num_ext, num_int, colonia, ciudad, municipio, estado, codigo_postal, id_pacientes', 'safe', 'on'=>'search'),
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
			'idPacientes' => array(self::BELONGS_TO, 'Pacientes', 'id_pacientes'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'razon_social' => 'Nombre completo de persona física o moral',
			'RFC' => 'RFC',
			'calle' => 'Calle',
			'num_ext' => 'Num Ext',
			'num_int' => 'Num Int',
			'colonia' => 'Colonia',
			'ciudad' => 'Ciudad',
			'municipio' => 'Municipio',
			'estado' => 'Estado',
			'codigo_postal' => 'Codigo Postal',
			'id_pacientes' => 'Id Pacientes',
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
		$criteria->compare('RFC',$this->RFC,true);
		$criteria->compare('calle',$this->calle,true);
		$criteria->compare('num_ext',$this->num_ext,true);
		$criteria->compare('num_int',$this->num_int,true);
		$criteria->compare('colonia',$this->colonia,true);
		$criteria->compare('ciudad',$this->ciudad,true);
		$criteria->compare('municipio',$this->municipio,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('codigo_postal',$this->codigo_postal,true);
		$criteria->compare('id_pacientes',$this->id_pacientes);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DatosFacturacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
