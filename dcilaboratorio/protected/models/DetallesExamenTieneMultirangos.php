<?php

/**
 * This is the model class for table "detalles_examen_tiene_multirangos".
 *
 * The followings are the available columns in table 'detalles_examen_tiene_multirangos':
 * @property integer $id
 * @property integer $id_detalles_examen
 * @property integer $id_multirangos
 *
 * The followings are the available model relations:
 * @property DetallesExamen $idDetallesExamen
 * @property Multirangos $idMultirangos
 */
class DetallesExamenTieneMultirangos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'detalles_examen_tiene_multirangos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_detalles_examen, id_multirangos', 'required'),
			array('id_detalles_examen, id_multirangos', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_detalles_examen, id_multirangos', 'safe', 'on'=>'search'),
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
			'idDetallesExamen' => array(self::BELONGS_TO, 'DetallesExamen', 'id_detalles_examen'),
			'idMultirangos' => array(self::BELONGS_TO, 'Multirangos', 'id_multirangos'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_detalles_examen' => 'Id Detalles Examen',
			'id_multirangos' => 'Id Multirangos',
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
		$criteria->compare('id_detalles_examen',$this->id_detalles_examen);
		$criteria->compare('id_multirangos',$this->id_multirangos);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DetallesExamenTieneMultirangos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
