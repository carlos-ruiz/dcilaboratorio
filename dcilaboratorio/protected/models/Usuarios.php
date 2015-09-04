<?php

/**
 * This is the model class for table "usuarios".
 *
 * The followings are the available columns in table 'usuarios':
 * @property integer $id
 * @property string $usuario
 * @property string $contrasena
 * @property string $ultima_edicion
 * @property integer $usuario_ultima_edicion
 * @property string $creacion
 * @property integer $usuario_creacion
 * @property integer $id_perfiles
 *
 * The followings are the available model relations:
 * @property Doctores $doctor
 * @property OrdenesFacturacion $ordenFacturacion
 * @property UnidadesResponsables[] $unidadesResponsables
 * @property Perfiles $idPerfiles
 */
class Usuarios extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'usuarios';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario, contrasena, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion, id_perfiles', 'required'),
			array('usuario_ultima_edicion, usuario_creacion, id_perfiles', 'numerical', 'integerOnly'=>true),
			array('usuario', 'length', 'max'=>45),
			array('contrasena', 'length', 'max'=>150),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, usuario, contrasena, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion, id_perfiles', 'safe', 'on'=>'search'),
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
			'doctor' => array(self::HAS_ONE, 'Doctores', 'id_usuarios'),
			'ordenFacturacion' => array(self::HAS_ONE, 'OrdenesFacturacion', 'id_usuarios'),
			'unidadesResponsables' => array(self::HAS_MANY, 'UnidadesResponsables', 'id_usuarios'),
			'perfil' => array(self::BELONGS_TO, 'Perfiles', 'id_perfiles'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'usuario' => 'Usuario',
			'contrasena' => 'Contraseña',
			'ultima_edicion' => 'Ultima Edición',
			'usuario_ultima_edicion' => 'Usuario Ultima Edición',
			'creacion' => 'Creación',
			'usuario_creacion' => 'Usuario Creación',
			'id_perfiles' => 'Perfil',
			'perfil.nombre' => 'Perfil',
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



		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Usuarios the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function count(){
		$criteria=new CDbCriteria();
		$criteria->select=count('id');
		$criteria->compare('id>',0);
		return Yii::app()->db->commandBuilder->createFindCommand($this->tableName(),$criteria)->queryScalar();
	}

	public function obtenerPorPerfil($perfil) {
		$perfil = Perfiles::model()->findByName($perfil);
		$usuarios = $this->model()->findAll("id_perfiles=?", array($perfil->id));
		$nombresDeUsuario = array();
		foreach ($usuarios as $usuario) {
			array_push($nombresDeUsuario, $usuario->usuario);
		}
		return $nombresDeUsuario;
	}
}
