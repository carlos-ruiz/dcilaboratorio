<?php

/**
 * This is the model class for table "direcciones".
 *
 * The followings are the available columns in table 'direcciones':
 * @property integer $id
 * @property string $calle
 * @property string $colonia
 * @property string $numero_ext
 * @property string $num_int
 * @property integer $codigo_postal
 * @property string $ultima_edicion
 * @property integer $usuario_ultima_edicion
 * @property string $creacion
 * @property integer $usuario_creacion
 * @property integer $id_estados
 * @property integer $id_municipio
 *
 * The followings are the available model relations:
 * @property DatosFacturacion[] $datosFacturacions
 * @property Estados $idEstados
 * @property Municipios $idMunicipio
 * @property Doctores[] $doctores
 * @property UnidadesResponsables[] $unidadesResponsables
 */
class Direcciones extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'direcciones';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('calle, colonia, numero_ext, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion, id_estados, id_municipio', 'required'),
			array('codigo_postal, usuario_ultima_edicion, usuario_creacion, id_estados, id_municipio', 'numerical', 'integerOnly'=>true),
			array('calle, colonia, numero_ext, num_int', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, calle, colonia, numero_ext, num_int, codigo_postal, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion, id_estados, id_municipio', 'safe', 'on'=>'search'),
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
			'datosFacturacions' => array(self::HAS_MANY, 'DatosFacturacion', 'id_direccion'),
			'estado' => array(self::BELONGS_TO, 'Estados', 'id_estados'),
			'municipio' => array(self::BELONGS_TO, 'Municipios', 'id_municipio'),
			'doctores' => array(self::HAS_MANY, 'Doctores', 'id_direccion'),
			'unidadesResponsables' => array(self::HAS_MANY, 'UnidadesResponsables', 'id_direccion'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'calle' => 'Calle',
			'colonia' => 'Colonia',
			'numero_ext' => 'Número Ext',
			'num_int' => 'Número Int',
			'codigo_postal' => 'Código Postal',
			'ultima_edicion' => 'Ultima Edicion',
			'usuario_ultima_edicion' => 'Usuario Ultima Edicion',
			'creacion' => 'Creacion',
			'usuario_creacion' => 'Usuario Creacion',
			'id_estados' => 'Estado',
			'id_municipio' => 'Municipio',
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
		$criteria->compare('calle',$this->calle,true);
		$criteria->compare('colonia',$this->colonia,true);
		$criteria->compare('numero_ext',$this->numero_ext,true);
		$criteria->compare('num_int',$this->num_int,true);
		$criteria->compare('codigo_postal',$this->codigo_postal);
		$criteria->compare('ultima_edicion',$this->ultima_edicion,true);
		$criteria->compare('usuario_ultima_edicion',$this->usuario_ultima_edicion);
		$criteria->compare('creacion',$this->creacion,true);
		$criteria->compare('usuario_creacion',$this->usuario_creacion);
		$criteria->compare('id_estados',$this->id_estados);
		$criteria->compare('id_municipio',$this->id_municipio);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Direcciones the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function obtenerEstados(){
		return CHtml::listData(Estados::model()->findAll(array('order'=>'nombre')), 'id', 'nombre');
	}

	public function obtenerMunicipios(){
		return CHtml::listData(Municipios::model()->findAll(array('order'=>'nombre')), 'id', 'nombre');
	}
}
