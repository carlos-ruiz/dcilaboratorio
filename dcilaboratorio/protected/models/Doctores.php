<?php

/**
 * This is the model class for table "doctores".
 *
 * The followings are the available columns in table 'doctores':
 * @property integer $id
 * @property string $nombre
 * @property string $a_paterno
 * @property string $a_materno
 * @property string $correo_electronico
 * @property string $hora_consulta_de
 * @property string $hora_consulta_hasta
 * @property integer $porcentaje
 * @property string $calle
 * @property string $ciudad
 * @property string $colonia
 * @property string $estado
 * @property string $codigo_postal
 * @property integer $numero_ext
 * @property string $numero_int
 * @property integer $id_especialidades
 * @property integer $id_titulos
 * @property integer $id_usuarios
 * @property string $ultima_edicion
 * @property integer $usuario_ultima_edicion
 * @property string $creacion
 * @property integer $usuario_creacion
 *
 * The followings are the available model relations:
 * @property Usuarios $idUsuarios
 * @property Especialidades $idEspecialidades
 * @property Titulos $idTitulos
 * @property Ordenes[] $ordenes
 * @property UnidadTieneDoctores[] $unidadTieneDoctores
 */
class Doctores extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'doctores';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, a_paterno, hora_consulta_de, hora_consulta_hasta, porcentaje, id_especialidades, id_titulos, id_usuarios, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion, calle, ciudad, colonia, estado, numero_ext, codigo_postal, correo_electronico', 'required'),
			array('porcentaje, codigo_postal, id_especialidades, id_titulos, id_usuarios, usuario_ultima_edicion, usuario_creacion', 'numerical', 'integerOnly'=>true),
			array('nombre, a_paterno, a_materno, correo_electronico, hora_consulta_de, hora_consulta_hasta, calle, ciudad, colonia, estado', 'length', 'max'=>45),
			array('codigo_postal', 'length', 'max'=>5),
			array('porcentaje', 'length', 'max'=>3),
			array('correo_electronico', 'email'),
			array('correo_electronico', 'unique',
				'attributeName' => 'correo_electronico',
				'message'=>'Ya existe un usuario registrado con este correo electrónico.'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, a_paterno, a_materno, correo_electronico, hora_consulta_de, hora_consulta_hasta, porcentaje, calle, ciudad, colonia, estado, codigo_postal, numero_ext, numero_int, id_especialidades, id_titulos, id_usuarios, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion', 'safe', 'on'=>'search'),
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
			'idUsuarios' => array(self::BELONGS_TO, 'Usuarios', 'id_usuarios'),
			'idEspecialidades' => array(self::BELONGS_TO, 'Especialidades', 'id_especialidades'),
			'idTitulos' => array(self::BELONGS_TO, 'Titulos', 'id_titulos'),
			'ordenes' => array(self::HAS_MANY, 'Ordenes', 'id_doctores'),
			'unidadTieneDoctores' => array(self::HAS_MANY, 'UnidadTieneDoctores', 'id_doctores'),
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
			'a_paterno' => 'Apellido Paterno',
			'a_materno' => 'Apellido Materno',
			'correo_electronico' => 'Correo Electrónico',
			'hora_consulta_de' => 'Hora Consulta De',
			'hora_consulta_hasta' => 'Hora Consulta Hasta',
			'porcentaje' => 'Porcentaje',
			'calle' => 'Calle',
			'ciudad' => 'Ciudad',
			'colonia' => 'Colonia',
			'estado' => 'Estado',
			'codigo_postal' => 'Código Postal',
			'numero_ext' => 'Número Ext',
			'numero_int' => 'Número Int',
			'id_especialidades' => 'Especialidad',
			'id_titulos' => 'Título',
			'id_usuarios' => 'Id Usuarios',
			'ultima_edicion' => 'Última edición',
			'usuario_ultima_edicion' => 'Usuario última edición',
			'creacion' => 'Creación',
			'usuario_creacion' => 'Usuario creación',
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
		$criteria->compare('a_paterno',$this->a_paterno,true);
		$criteria->compare('a_materno',$this->a_materno,true);
		$criteria->compare('correo_electronico',$this->correo_electronico,true);
		$criteria->compare('hora_consulta_de',$this->hora_consulta_de,true);
		$criteria->compare('hora_consulta_hasta',$this->hora_consulta_hasta,true);
		$criteria->compare('porcentaje',$this->porcentaje);
		$criteria->compare('calle',$this->calle,true);
		$criteria->compare('ciudad',$this->ciudad,true);
		$criteria->compare('colonia',$this->colonia,true);
		$criteria->compare('estado',$this->estado,true);
		$criteria->compare('codigo_postal',$this->codigo_postal,true);
		$criteria->compare('numero_ext',$this->numero_ext);
		$criteria->compare('numero_int',$this->numero_int,true);
		$criteria->compare('id_especialidades',$this->id_especialidades);
		$criteria->compare('id_titulos',$this->id_titulos);
		$criteria->compare('id_usuarios',$this->id_usuarios);
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
	 * @return Doctores the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	public function obtenerTitulos(){
		return CHtml::listData(TitulosForm::model()->findAll(), 'id', 'nombre');
	}

	public function obtenerEspecialidades(){
		return CHtml::listData(Especialidades::model()->findAll(), 'id', 'nombre');
	} 
}
