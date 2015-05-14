<?php

/**
 * This is the model class for table "detalles_examen".
 *
 * The followings are the available columns in table 'detalles_examen':
 * @property integer $id
 * @property string $descripcion
 * @property integer $id_unidades_medida
 * @property integer $id_examenes
 * @property string $ultima_edicion
 * @property integer $usuario_ultima_edicion
 * @property string $creacion
 * @property integer $usuario_creacion
 *
 * The followings are the available model relations:
 * @property Examenes $idExamenes
 * @property UnidadesMedida $idUnidadesMedida
 * @property OrdenTieneExamenes[] $ordenTieneExamenes
 */
class DetallesExamen extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'detalles_examen';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('descripcion, id_unidades_medida, id_examenes, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion', 'required'),
			array('id_unidades_medida, id_examenes, usuario_ultima_edicion, usuario_creacion', 'numerical', 'integerOnly'=>true),
			array('descripcion', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, descripcion, id_unidades_medida, id_examenes, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion', 'safe', 'on'=>'search'),
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
			'examenes' => array(self::BELONGS_TO, 'Examenes', 'id_examenes'),
			'unidadesMedida' => array(self::BELONGS_TO, 'UnidadesMedida', 'id_unidades_medida'),
			'ordenTieneExamenes' => array(self::HAS_MANY, 'OrdenTieneExamenes', 'id_detalles_examen'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'descripcion' => 'Descripción',
			'id_unidades_medida' => 'Unidades Medida',
			'id_examenes' => 'Examen',
			'ultima_edicion' => 'Ultima Edicion',
			'usuario_ultima_edicion' => 'Usuario Ultima Edicion',
			'creacion' => 'Creacion',
			'usuario_creacion' => 'Usuario Creacion',
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
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('id_unidades_medida',$this->id_unidades_medida);
		$criteria->compare('id_examenes',$this->id_examenes);
		$criteria->compare('ultima_edicion',$this->ultima_edicion,true);
		$criteria->compare('usuario_ultima_edicion',$this->usuario_ultima_edicion);
		$criteria->compare('creacion',$this->creacion,true);
		$criteria->compare('usuario_creacion',$this->usuario_creacion);
		$this->dbCriteria->order='activo DESC, descripcion ASC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return DetallesExamen the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function obtenerUnidadesMedida(){
		return CHtml::listData(UnidadesMedida::model()->findAll(), 'id', 'nombre');
	}

	public function obtenerExamenes(){
		return CHtml::listData(Examenes::model()->findAll(), 'id', 'nombre');
	}

	
}

