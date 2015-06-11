<?php

/**
 * This is the model class for table "orden_precio_examen".
 *
 * The followings are the available columns in table 'orden_precio_examen':
 * @property integer $id
 * @property string $precio
 * @property integer $id_examenes
 * @property integer $id_ordenes
 *
 * The followings are the available model relations:
 * @property Examenes $idExamenes
 * @property Ordenes $idOrdenes
 */
class OrdenPrecioExamen extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'orden_precio_examen';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('precio, id_examenes, id_ordenes', 'required'),
			array('id_examenes, id_ordenes', 'numerical', 'integerOnly'=>true),
			array('precio', 'length', 'max'=>7),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, precio, id_examenes, id_ordenes', 'safe', 'on'=>'search'),
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
			'examen' => array(self::BELONGS_TO, 'Examenes', 'id_examenes'),
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
			'precio' => 'Precio',
			'id_examenes' => 'Id Examenes',
			'id_ordenes' => 'Id Ordenes',
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
		$criteria->compare('precio',$this->precio,true);
		$criteria->compare('id_examenes',$this->id_examenes);
		$criteria->compare('id_ordenes',$this->id_ordenes);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrdenPrecioExamen the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
