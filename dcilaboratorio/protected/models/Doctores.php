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
 * @property integer $id_especialidades
 * @property integer $id_titulos
 * @property integer $id_usuarios
 * @property string $ultima_edicion
 * @property integer $usuario_ultima_edicion
 * @property string $creacion
 * @property integer $usuario_creacion
 * @property integer $activo
 * @property integer $id_direccion
 *
 * The followings are the available model relations:
 * @property Usuarios $usuario
 * @property Direccion $direccion
 * @property Especialidades $especialidad
 * @property Titulos $titulo
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
			array('nombre, a_paterno, hora_consulta_de, hora_consulta_hasta, id_especialidades, id_titulos, id_usuarios, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion, id_direccion, correo_electronico', 'required'),
			array('id_especialidades, id_titulos, id_usuarios, usuario_ultima_edicion, usuario_creacion, activo, id_direccion', 'numerical', 'integerOnly'=>true),
			array('nombre, a_paterno, a_materno, correo_electronico, hora_consulta_de, hora_consulta_hasta', 'length', 'max'=>45),
			array('nombre', 'length', 'min'=>3),
			array('correo_electronico', 'email'),
			array('correo_electronico', 'unique',
				'attributeName' => 'correo_electronico',
				'message'=>'Ya existe un usuario registrado con este correo electrónico.'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre, a_paterno, a_materno, correo_electronico, hora_consulta_de, hora_consulta_hasta, id_especialidades, id_titulos, id_usuarios, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion, activo, id_direccion', 'safe', 'on'=>'search'),
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
			'usuario' => array(self::BELONGS_TO, 'Usuarios', 'id_usuarios'),
			'direccion' => array(self::BELONGS_TO, 'Direcciones', 'id_direccion'),
			'especialidad' => array(self::BELONGS_TO, 'Especialidades', 'id_especialidades'),
			'titulo' => array(self::BELONGS_TO, 'TitulosForm', 'id_titulos'),
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
			'nombre' => 'Nombre(s)',
			'a_paterno' => 'Apellido paterno',
			'a_materno' => 'Apellido materno',
			'correo_electronico' => 'Correo electrónico',
			'hora_consulta_de' => 'Inicia consulta',
			'hora_consulta_hasta' => 'Termina consulta',
			'id_especialidades' => 'Especialidad',
			'id_titulos' => 'Título',
			'id_usuarios' => 'Id Usuarios',
			'ultima_edicion' => 'Ultima Edicion',
			'usuario_ultima_edicion' => 'Usuario Ultima Edicion',
			'creacion' => 'Creacion',
			'usuario_creacion' => 'Usuario Creacion',
			'activo' => 'Activo',
			'id_direccion' => 'Id Direccion',
			'especialidad.nombre' => 'Especialidad',
			'titulo.nombre' => 'Título',
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
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('a_paterno',$this->a_paterno,true);
		$criteria->compare('a_materno',$this->a_materno,true);
		$criteria->compare('correo_electronico',$this->correo_electronico,true);
		$criteria->compare('hora_consulta_de',$this->hora_consulta_de,true);
		$criteria->compare('hora_consulta_hasta',$this->hora_consulta_hasta,true);
		$criteria->compare('id_especialidades',$this->id_especialidades);
		$criteria->compare('id_titulos',$this->id_titulos);
		$criteria->compare('id_usuarios',$this->id_usuarios);
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
	 * @return Doctores the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function obtenerTitulos(){
		return CHtml::listData(TitulosForm::model()->findAll(array('condition'=>'activo=1','order'=>'nombre')), 'id', 'nombre');
	}

	public function obtenerEspecialidades(){
		return CHtml::listData(Especialidades::model()->findAll(array('condition'=>'activo=1','order'=>'nombre')), 'id', 'nombre');
	}

	public function obtenerNombreCompleto(){
		return $this->titulo->nombre.' '.$this->nombre.' '.$this->a_paterno.' '.$this->a_materno;
	}

	public function getNombreCompleto(){
		return $this->nombre.' '.$this->a_paterno.' '.$this->a_materno;
	}

	public function obtenerPorUserId($id){
		return $this->model()->find("id_usuarios=?",array($id));
	}

	public function selectList(){
		$models = $this->model()->findAll('activo=1');
		$data = array(null=>"--Seleccione--");
		foreach ($models as $model) {
				$data[$model->id]=$model->obtenerNombreCompleto();
		}
		return $data;
	}

	// public function ursPorDoctor($value=0)
	// {
	// 	$list=UnidadTieneDoctores::model()->findAll("id_doctores",array($value));
	// 	foreach($list as $data)
	// 		echo "<option value=\"{$data->idUnidadesResponsables->id}\">{$data->idUnidadesResponsables->nombre}</option>";
	// }
}
