<?php

/**
 * This is the model class for table "conceptos_factura".
 *
 * The followings are the available columns in table 'conceptos_factura':
 * @property integer $id
 * @property string $clave
 * @property string $descripcion
 * @property string $precio
 * @property integer $id_facturas_expedidas
 *
 * The followings are the available model relations:
 * @property FacturasExpedidas $idFacturasExpedidas
 */
class ConceptosFactura extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'conceptos_factura';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('clave, descripcion, precio, id_facturas_expedidas', 'required'),
			array('id_facturas_expedidas', 'numerical', 'integerOnly'=>true),
			array('clave', 'length', 'max'=>45),
			array('descripcion', 'length', 'max'=>100),
			array('precio', 'length', 'max'=>9),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, clave, descripcion, precio, id_facturas_expedidas', 'safe', 'on'=>'search'),
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
			'factura' => array(self::BELONGS_TO, 'FacturasExpedidas', 'id_facturas_expedidas'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'clave' => 'Clave',
			'descripcion' => 'Descripción',
			'precio' => 'Precio',
			'id_facturas_expedidas' => 'Id Factura',
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
		$criteria->compare('clave',$this->clave,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('precio',$this->precio,true);
		$criteria->compare('id_facturas_expedidas',$this->id_facturas_expedidas);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ConceptosFactura the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
