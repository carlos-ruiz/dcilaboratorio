<?php

/**
 * This is the model class for table "orden_tiene_multirangos".
 *
 * The followings are the available columns in table 'orden_tiene_multirangos':
 * @property integer $id
 * @property integer $id_orden_tiene_examenes
 * @property integer $id_multirangos
 * @property string $rango_inferior
 * @property string $rango_superior
 *
 * The followings are the available model relations:
 * @property Multirangos $idMultirangos
 * @property OrdenTieneExamenes $idOrdenTieneExamenes
 */
class OrdenTieneMultirangos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'orden_tiene_multirangos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_orden_tiene_examenes, id_multirangos, rango_inferior, rango_superior', 'required'),
			array('id_orden_tiene_examenes, id_multirangos', 'numerical', 'integerOnly'=>true),
			array('rango_inferior, rango_superior', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_orden_tiene_examenes, id_multirangos, rango_inferior, rango_superior', 'safe', 'on'=>'search'),
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
			'multirango' => array(self::BELONGS_TO, 'Multirangos', 'id_multirangos'),
			'ordenTieneExamenes' => array(self::BELONGS_TO, 'OrdenTieneExamenes', 'id_orden_tiene_examenes'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_orden_tiene_examenes' => 'Id Orden Tiene Examenes',
			'id_multirangos' => 'Id Multirangos',
			'rango_inferior' => 'Rango Inferior',
			'rango_superior' => 'Rango Superior',
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
		$criteria->compare('id_orden_tiene_examenes',$this->id_orden_tiene_examenes);
		$criteria->compare('id_multirangos',$this->id_multirangos);
		$criteria->compare('rango_inferior',$this->rango_inferior,true);
		$criteria->compare('rango_superior',$this->rango_superior,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrdenTieneMultirangos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
