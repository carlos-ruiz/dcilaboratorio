<?php

/**
 * This is the model class for table "ordenes_facturacion".
 *
 * The followings are the available columns in table 'ordenes_facturacion':
 * @property integer $id
 * @property integer $id_datos_facturacion
 * @property integer $id_ordenes
 * @property integer $id_pacientes
 *
 * The followings are the available model relations:
 * @property DatosFacturacion $idDatosFacturacion
 * @property Ordenes $idOrdenes
 * @property Pacientes $idPacientes
 */
class OrdenesFacturacion extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ordenes_facturacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_ordenes, id_pacientes', 'required'),
			array('id_datos_facturacion, id_ordenes, id_pacientes', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_datos_facturacion, id_ordenes, id_pacientes', 'safe', 'on'=>'search'),
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
			'idDatosFacturacion' => array(self::BELONGS_TO, 'DatosFacturacion', 'id_datos_facturacion'),
			'idOrdenes' => array(self::BELONGS_TO, 'Ordenes', 'id_ordenes'),
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
			'id_datos_facturacion' => 'Id Datos Facturacion',
			'id_ordenes' => 'Id Ordenes',
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
		$criteria->compare('id_datos_facturacion',$this->id_datos_facturacion);
		$criteria->compare('id_ordenes',$this->id_ordenes);
		$criteria->compare('id_pacientes',$this->id_pacientes);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrdenesFacturacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
