<?php

/**
 * This is the model class for table "unidad_tiene_doctores".
 *
 * The followings are the available columns in table 'unidad_tiene_doctores':
 * @property integer $id
 * @property integer $id_unidades_responsables
 * @property integer $id_doctores
 * @property string $ultima_edicion
 * @property integer $usuario_ultima_edicion
 * @property string $creacion
 * @property integer $usuario_creacion
 *
 * The followings are the available model relations:
 * @property Doctores $idDoctores
 * @property UnidadesResponsables $idUnidadesResponsables
 */
class UnidadTieneDoctores extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'unidad_tiene_doctores';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_unidades_responsables, id_doctores, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion', 'required'),
			array('id_unidades_responsables, id_doctores, usuario_ultima_edicion, usuario_creacion', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_unidades_responsables, id_doctores, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion', 'safe', 'on'=>'search'),
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
			'idDoctores' => array(self::BELONGS_TO, 'Doctores', 'id_doctores','condition'=>'idDoctores.activo=1'),
			'idUnidadesResponsables' => array(self::BELONGS_TO, 'UnidadesResponsables', 'id_unidades_responsables','condition'=>'idUnidadesResponsables.activo=1'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_unidades_responsables' => 'Id Unidades Responsables',
			'id_doctores' => 'Id Doctores',
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
		$criteria->compare('id_unidades_responsables',$this->id_unidades_responsables);
		$criteria->compare('id_doctores',$this->id_doctores);
		$criteria->compare('ultima_edicion',$this->ultima_edicion,true);
		$criteria->compare('usuario_ultima_edicion',$this->usuario_ultima_edicion);
		$criteria->compare('creacion',$this->creacion,true);
		$criteria->compare('usuario_creacion',$this->usuario_creacion);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UnidadTieneDoctores the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function obtenerUnidadesPorDoctor($doctor_id){
		$urs = Yii::app()->db->createCommand()
		    ->select('*')
		    ->from('unidad_tiene_doctores')
		    ->where('id_doctores=:doctor_id', array(':doctor_id'=>$doctor_id))
		    ->queryAll();		    
		return $urs; 
	}
}
