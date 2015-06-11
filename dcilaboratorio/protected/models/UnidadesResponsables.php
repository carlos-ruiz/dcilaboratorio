<?php

/**
 * This is the model class for table "unidades_responsables".
 *
 * The followings are the available columns in table 'unidades_responsables':
 * @property integer $id
 * @property string $clave
 * @property string $nombre
 * @property string $hora_inicial
 * @property string $hora_final
 * @property string $responsable_sanitario
 * @property string $responsable_administrativo
 * @property string $sugerencias
 * @property string $ultima_edicion
 * @property integer $usuario_ultima_edicion
 * @property string $creacion
 * @property integer $usuario_creacion
 * @property integer $activo
 * @property integer $id_direccion
 *
 * The followings are the available model relations:
 * @property Ordenes[] $ordenes
 * @property UnidadTieneDoctores[] $unidadTieneDoctores
 * @property Direcciones $idDireccion
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
			array('nombre, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion, id_direccion', 'required'),
			array('usuario_ultima_edicion, usuario_creacion, activo, id_direccion', 'numerical', 'integerOnly'=>true),
			array('clave, nombre, hora_inicial, hora_final', 'length', 'max'=>45),
			array('responsable_sanitario, responsable_administrativo', 'length', 'max'=>250),
			array('sugerencias', 'length', 'max'=>300),
			array('nombre, clave', 'unique'),

			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, clave, nombre, hora_inicial, hora_final, responsable_sanitario, responsable_administrativo, sugerencias, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion, activo, id_direccion', 'safe', 'on'=>'search'),
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
			'direccion' => array(self::BELONGS_TO, 'Direcciones', 'id_direccion'),
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
			'nombre' => 'Nombre',
			'hora_inicial' => 'Hora Inicial',
			'hora_final' => 'Hora Final',
			'responsable_sanitario' => 'Responsable Sanitario',
			'responsable_administrativo' => 'Responsable Administrativo',
			'sugerencias' => 'Sugerencias',
			'ultima_edicion' => 'Ultima Edicion',
			'usuario_ultima_edicion' => 'Usuario Ultima Edicion',
			'creacion' => 'Creacion',
			'usuario_creacion' => 'Usuario Creacion',
			'activo' => 'Activo',
			'id_direccion' => 'Direccion',
			'direccion.estado.nombre' => 'Estado',
			'direccion.municipio.nombre' => 'Municipio',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('hora_inicial',$this->hora_inicial,true);
		$criteria->compare('hora_final',$this->hora_final,true);
		$criteria->compare('responsable_sanitario',$this->responsable_sanitario,true);
		$criteria->compare('responsable_administrativo',$this->responsable_administrativo,true);
		$criteria->compare('sugerencias',$this->sugerencias,true);
		$criteria->compare('ultima_edicion',$this->ultima_edicion,true);
		$criteria->compare('usuario_ultima_edicion',$this->usuario_ultima_edicion);
		$criteria->compare('creacion',$this->creacion,true);
		$criteria->compare('usuario_creacion',$this->usuario_creacion);
		$criteria->compare('activo',$this->activo);
		$criteria->compare('id_direccion',$this->id_direccion);
		$this->dbCriteria->order='activo DESC, nombre ASC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
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
