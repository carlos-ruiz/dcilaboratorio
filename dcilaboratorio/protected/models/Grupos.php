<?php

/**
 * This is the model class for table "grupos_examenes".
 *
 * The followings are the available columns in table 'grupos_examenes':
 * @property integer $id
 * @property string $nombre
 * @property string $ultima_edicion
 * @property integer $usuario_ultima_edicion
 * @property string $creacion
 * @property integer $usuario_creacion
 *
 * The followings are the available model relations:
 * @property GrupoTieneExamenes[] $grupoTieneExamenes
 */

class Grupos extends CActiveRecord
{

	public $examenes;
	public $grupos;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'grupos_examenes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, ultima_edicion, clave, usuario_ultima_edicion, creacion, usuario_creacion', 'required'),
			array('nombre', 'unique'),
			array('usuario_ultima_edicion, usuario_creacion', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>250),
			array('comentarios', 'length', 'max'=>250),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nombre,  comentarios, clave, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion', 'safe', 'on'=>'search'),
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
			'grupoTiene' => array(self::HAS_MANY, 'GrupoExamenes', 'id_grupos_examenes','together'=>true),
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
			'comentarios'=>'Método',
			'clave'=>'Clave',
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
		$criteria->compare('clave',$this->clave,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('comentarios',$this->comentarios,true);
		$criteria->compare('ultima_edicion',$this->ultima_edicion,true);
		$criteria->compare('usuario_ultima_edicion',$this->usuario_ultima_edicion);
		$criteria->compare('creacion',$this->creacion,true);
		$criteria->compare('usuario_creacion',$this->usuario_creacion);
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
	 * @return GruposExamenes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function selectList(){
		$grupos = $this->model()->findAll('activo=1');
		$data = array(null=>"--Seleccione--");
		foreach ($grupos as $grupo) {
				$data[$grupo->id]=$grupo->nombre;
		}
		return $data;
	}

	public function selectListMultiple($idPadre=0){
		$grupos = $this->model()->findAll('activo=1');
		$data = array();
		foreach ($grupos as $grupo) {
			if($grupo->id!==$idPadre)
				$data[$grupo->id]=$grupo->nombre;
		}
		return $data;
	}

	public function perfilEsHijoDe($idHijo, $idPadre){
		$resultado = GruposPerfiles::model()->find('id_grupo_padre=? AND id_grupo_hijo=?',array($idPadre, $idHijo));
		if (isset($resultado)) {
			return 1;
		}else {
			return 0;
		}
	}
}