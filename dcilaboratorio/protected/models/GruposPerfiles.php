<?php

/**
 * This is the model class for table "grupos_perfiles".
 *
 * The followings are the available columns in table 'grupos_perfiles':
 * @property integer $id
 * @property integer $id_grupo_padre
 * @property integer $id_grupo_hijo
 * @property string $ultima_edicion
 * @property integer $usuario_ultima_edicion
 * @property string $creacion
 * @property integer $usuario_creacion
 * @property integer $activo
 *
 * The followings are the available model relations:
 * @property GruposExamenes $idGrupoHijo
 * @property GruposExamenes $idGrupoPadre
 */
class GruposPerfiles extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'grupos_perfiles';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_grupo_padre, id_grupo_hijo, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion', 'required'),
			array('id_grupo_padre, id_grupo_hijo, usuario_ultima_edicion, usuario_creacion, activo', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_grupo_padre, id_grupo_hijo, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion, activo', 'safe', 'on'=>'search'),
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
			'idGrupoHijo' => array(self::BELONGS_TO, 'Grupos', 'id_grupo_hijo'),
			'idGrupoPadre' => array(self::BELONGS_TO, 'Grupos', 'id_grupo_padre'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_grupo_padre' => 'Id Grupo Padre',
			'id_grupo_hijo' => 'Id Grupo Hijo',
			'ultima_edicion' => 'Ultima Edicion',
			'usuario_ultima_edicion' => 'Usuario Ultima Edicion',
			'creacion' => 'Creacion',
			'usuario_creacion' => 'Usuario Creacion',
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
		$criteria->compare('id_grupo_padre',$this->id_grupo_padre);
		$criteria->compare('id_grupo_hijo',$this->id_grupo_hijo);
		$criteria->compare('ultima_edicion',$this->ultima_edicion,true);
		$criteria->compare('usuario_ultima_edicion',$this->usuario_ultima_edicion);
		$criteria->compare('creacion',$this->creacion,true);
		$criteria->compare('usuario_creacion',$this->usuario_creacion);
		$criteria->compare('activo',$this->activo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GruposPerfiles the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function findGruposForGrupo($id){
		return $this->model()->findAll("id_grupo_padre=?",array($id));
	}
}
