<?php

/**
 * This is the model class for table "unidades_responsables".
 *
 * The followings are the available columns in table 'unidades_responsables':
 * @property integer $id
 * @property string $nombre
 * @property string $ultima_edicion
 * @property integer $usuario_ultima_edicion
 * @property string $creacion
 * @property integer $usuario_creacion
 * @property integer $id_usuarios
 *
 * The followings are the available model relations:
 * @property Ordenes[] $ordenes
 * @property UnidadTieneDoctores[] $unidadTieneDoctores
 * @property Usuarios $idUsuarios
 */
class UnidadesResponsables extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'unidades_responsables';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion', 'required'),
			array('usuario_ultima_edicion, usuario_creacion', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>45),
			array('nombre', 'length', 'min'=>3),
array('nombre', 'unique'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion', 'safe', 'on'=>'search'),
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
			'ordenes' => array(self::HAS_MANY, 'Ordenes', 'id_unidades_responsables'),
			'unidadTieneDoctores' => array(self::HAS_MANY, 'UnidadTieneDoctores', 'id_unidades_responsables'),
			'usuarios' => array(self::BELONGS_TO, 'Usuarios', 'id_usuarios'),
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('ultima_edicion',$this->ultima_edicion,true);
		$criteria->compare('usuario_ultima_edicion',$this->usuario_ultima_edicion);
		$criteria->compare('creacion',$this->creacion,true);
		$criteria->compare('usuario_creacion',$this->usuario_creacion);
		$this->dbCriteria->order='activo DESC, nombre ASC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UnidadesResponsables the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

}