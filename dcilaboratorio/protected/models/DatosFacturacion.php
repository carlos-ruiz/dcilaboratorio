<?php

/**
 * This is the model class for table "datos_facturacion".
 *
 * The followings are the available columns in table 'datos_facturacion':
 * @property integer $id
 * @property string $razon_social
 * @property string $RFC
 * @property string $id_direccion
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
			array('id, RFC, razon_social, id_direccion,', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('razon_social', 'length', 'max'=>500),
			array('RFC', 'length', 'max'=>13),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, razon_social, RFC, id_direccion', 'safe', 'on'=>'search'),
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
			'direccion' => array(self::BELONGS_TO, 'Direcciones', 'id_direccion'),
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
			'id_direccion' => 'Direccion',
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
		$criteria->compare('id_direccion',$this->id_direccion,true);
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
