<?php

/**
 * This is the model class for table "pacientes".
 *
 * The followings are the available columns in table 'pacientes':
 * @property integer $id
 * @property string $nombre
 * @property string $a_paterno
 * @property string $a_materno
 * @property string $fecha_nacimiento
 * @property integer $sexo
 * @property string $email
 * @property string $ultima_edicion
 * @property integer $usuario_ultima_edicion
 * @property string $creacion
 * @property integer $usuario_creacion
 * @property integer $id_usuarios
 * @property integer $activo
 *
 * The followings are the available model relations:
 * @property DatosFacturacion[] $datosFacturacions
 * @property Ordenes[] $ordenes
 * @property Usuarios $idUsuarios
 */
class Pacientes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pacientes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, a_paterno, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion, fecha_nacimiento, sexo', 'required'),
			array('sexo, usuario_ultima_edicion, usuario_creacion, id_usuarios, activo', 'numerical', 'integerOnly'=>true),
			array('nombre, a_paterno, a_materno, email', 'length', 'max'=>45),
			array('fecha_nacimiento', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, a_paterno, a_materno, fecha_nacimiento, sexo, email, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion, id_usuarios, activo', 'safe', 'on'=>'search'),
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
			'datosFacturacions' => array(self::HAS_MANY, 'DatosFacturacion', 'id_pacientes'),
			'ordenes' => array(self::HAS_MANY, 'Ordenes', 'id_pacientes'),
			'usuario' => array(self::BELONGS_TO, 'Usuarios', 'id_usuarios'),
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
			'fecha_nacimiento' => 'Fecha Nacimiento',
			'sexo' => 'Sexo',
			'email' => 'Correo electrónico',
			'ultima_edicion' => 'Ultima Edicion',
			'usuario_ultima_edicion' => 'Usuario Ultima Edicion',
			'creacion' => 'Creacion',
			'usuario_creacion' => 'Usuario Creacion',
			'id_usuarios' => 'Id Usuarios',
			'activo' => 'Activo',
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
		$criteria->compare('fecha_nacimiento',$this->fecha_nacimiento,true);
		$criteria->compare('sexo',$this->sexo);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('ultima_edicion',$this->ultima_edicion,true);
		$criteria->compare('usuario_ultima_edicion',$this->usuario_ultima_edicion);
		$criteria->compare('creacion',$this->creacion,true);
		$criteria->compare('usuario_creacion',$this->usuario_creacion);
		$criteria->compare('id_usuarios',$this->id_usuarios);
		$criteria->compare('activo',$this->activo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pacientes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function selectListWithMail(){
		$pacientes = $this->model()->findAll('activo=1');
		$data=array();
		foreach ($pacientes as $paciente) {
			$data[$paciente->id]=$paciente->nombre." ".$paciente->a_paterno." ".$paciente->a_materno." - ".date("j/m/Y", strtotime($paciente->fecha_nacimiento));
		}
		return $data;
	}
}
