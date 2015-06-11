<?php

/**
 * This is the model class for table "contactos".
 *
 * The followings are the available columns in table 'contactos':
 * @property integer $id
 * @property string $contacto
 * @property integer $id_tipos_contacto
 * @property string $ultima_edicion
 * @property integer $usuario_ultima_edicion
 * @property string $creacion
 * @property integer $usuario_creacion
 * @property integer $id_persona
 * @property integer $id_perfiles
 *
 * The followings are the available model relations:
 * @property Perfiles $idPerfiles
 * @property TiposContacto $idTiposContacto
 */
class Contactos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'contactos';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contacto, id_tipos_contacto, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion, id_persona, id_perfiles', 'required'),
			array('id_tipos_contacto, usuario_ultima_edicion, usuario_creacion, id_persona, id_perfiles', 'numerical', 'integerOnly'=>true),
			array('contacto', 'length', 'max'=>50),
			array('ultima_edicion', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, contacto, id_tipos_contacto, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion, id_persona, id_perfiles', 'safe', 'on'=>'search'),
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
			'idPerfiles' => array(self::BELONGS_TO, 'Perfiles', 'id_perfiles'),
			'idTiposContacto' => array(self::BELONGS_TO, 'TiposContacto', 'id_tipos_contacto'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'contacto' => 'Contacto',
			'id_tipos_contacto' => 'Id Tipos Contacto',
			'ultima_edicion' => 'Ultima Edicion',
			'usuario_ultima_edicion' => 'Usuario Ultima Edicion',
			'creacion' => 'Creacion',
			'usuario_creacion' => 'Usuario Creacion',
			'id_persona' => 'Id Persona',
			'id_perfiles' => 'Id Perfiles',
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
		$criteria->compare('contacto',$this->contacto,true);
		$criteria->compare('id_tipos_contacto',$this->id_tipos_contacto);
		$criteria->compare('ultima_edicion',$this->ultima_edicion,true);
		$criteria->compare('usuario_ultima_edicion',$this->usuario_ultima_edicion);
		$criteria->compare('creacion',$this->creacion,true);
		$criteria->compare('usuario_creacion',$this->usuario_creacion);
		$criteria->compare('id_persona',$this->id_persona);
		$criteria->compare('id_perfiles',$this->id_perfiles);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,,
			'pagination'=>false,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Contactos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function findByUser($user_id, $tipo_id, $perfil_id){
		$contactos = Yii::app()->db->createCommand()
		    ->select('id, contacto, id_tipos_contacto')
		    ->from('contactos')
		    ->where('id_persona=:user_id', array(':user_id'=>$user_id))
		    ->andWhere('id_tipos_contacto=:tipo_id', array(':tipo_id'=>$tipo_id))
		    ->andWhere('id_perfiles=:perfil', array('perfil'=>$perfil_id))
		    ->queryRow();
		return $contactos; 
	}

	public function findAllByUser($user_id, $perfil_id){
		$contactos = Yii::app()->db->createCommand()
		    ->select('id, contacto, id_tipos_contacto')
		    ->from('contactos')
		    ->where('id_persona=:user_id', array(':user_id'=>$user_id))
		    ->andWhere('id_perfiles=:perfil', array('perfil'=>$perfil_id))
		    ->queryRow();
		return $contactos; 
	}
}
