<?php

/**
 * This is the model class for table "tarifas_activas".
 *
 * The followings are the available columns in table 'tarifas_activas':
 * @property integer $id
 * @property integer $id_examenes
 * @property integer $id_multitarifarios
 * @property double $precio
 * @property string $ultima_edicion
 * @property integer $usuario_ultima_edicion
 * @property string $creacion
 * @property integer $usuario_creacion
 *
 * The followings are the available model relations:
 * @property Examenes $idExamenes
 * @property Multitarifarios $idMultitarifarios
 */
class TarifasActivas extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tarifas_activas';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_examenes, id_multitarifarios, precio, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion', 'required'),
			array('id_examenes, id_multitarifarios, usuario_ultima_edicion, usuario_creacion', 'numerical', 'integerOnly'=>true),
			array('precio', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_examenes, id_multitarifarios, precio, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion', 'safe', 'on'=>'search'),
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
			'multitarifario' => array(self::BELONGS_TO, 'Multitarifarios', 'id_multitarifarios'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_examenes' => 'Determinación',
			'id_multitarifarios' => 'Multitarifario',
			'precio' => 'Precio',
			'ultima_edicion' => 'Ultima Edicion',
			'usuario_ultima_edicion' => 'Usuario Ultima Edicion',
			'creacion' => 'Creacion',
			'usuario_creacion' => 'Usuario Creacion',
			'multitarifario.nombre'=>'Multitarifario',
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
		$criteria->compare('id_examenes',$this->id_examenes);
		$criteria->compare('id_multitarifarios',$this->id_multitarifarios);
		$criteria->compare('precio',$this->precio);
		$criteria->compare('ultima_edicion',$this->ultima_edicion,true);
		$criteria->compare('usuario_ultima_edicion',$this->usuario_ultima_edicion);
		$criteria->compare('creacion',$this->creacion,true);
		$criteria->compare('usuario_creacion',$this->usuario_creacion);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TarifasActivas the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function obtenerMultitarifarios(){
		return CHtml::listData(Multitarifarios::model()->findAll('activo=1'), 'id', 'nombre');
	}

	public function obtenerExamenes(){
		return CHtml::listData(Examenes::model()->findAll('activo=1'), 'id', 'nombre');
	}

}
