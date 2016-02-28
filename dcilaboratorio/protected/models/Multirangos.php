<?php

/**
 * This is the model class for table "multirangos".
 *
 * The followings are the available columns in table 'multirangos':
 * @property integer $id
 * @property string $nombre
 * @property string $rango_inferior
 * @property string $rango_superior
 *
 * The followings are the available model relations:
 * @property DetallesExamenTieneMultirangos[] $detallesExamenTieneMultirangoses
 */
class Multirangos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */

	public function tableName()
	{
		return 'multirangos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, rango_inferior, rango_superior, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion', 'required'),
			array('nombre', 'length', 'max'=>45),
			array('rango_inferior, rango_superior', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, rango_inferior, rango_superior', 'safe', 'on'=>'search'),
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
			'detallesExamenTieneMultirangoses' => array(self::HAS_MANY, 'DetallesExamenTieneMultirangos', 'id_multirangos'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('rango_inferior',$this->rango_inferior,true);
		$criteria->compare('rango_superior',$this->rango_superior,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Multirangos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function selectListMultiple(){
		$multirangos = $this->model()->findAll('activo=1');
		$data = array();
		foreach ($multirangos as $multirango) {
			$data[$multirango->id]=$multirango->nombre." => ".$multirango->rango_inferior." - ".$multirango->rango_superior;
		}
		return $data;
	}
}
