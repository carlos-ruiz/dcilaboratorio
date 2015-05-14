<?php

/**
 * This is the model class for table "ordenes".
 *
 * The followings are the available columns in table 'ordenes':
 * @property integer $id
 * @property integer $id_doctores
 * @property integer $id_pacientes
 * @property integer $id_status
 * @property integer $id_unidades_responsables
 * @property string $fecha_captura
 * @property string $informacion_clinica_y_terapeutica
 * @property string $comentarios
 * @property integer $requiere_factura
 * @property integer $descuento
 * @property integer $id_multitarifarios
 * @property integer $compartir_con_doctor
 * @property string $ultima_edicion
 * @property integer $usuario_ultima_edicion
 * @property string $creacion
 * @property integer $usuario_creacion
 *
 * The followings are the available model relations:
 * @property OrdenTieneExamenes[] $ordenTieneExamenes
 * @property Doctores $idDoctores
 * @property Multitarifarios $idMultitarifarios
 * @property Pacientes $idPacientes
 * @property Status $idStatus
 * @property UnidadesResponsables $idUnidadesResponsables
 * @property Pagos[] $pagoses
 */
class Ordenes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ordenes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_doctores, id_pacientes, id_status, id_unidades_responsables, fecha_captura, id_multitarifarios, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion', 'required'),
			array('id_doctores, id_pacientes, id_status, id_unidades_responsables, requiere_factura, descuento, id_multitarifarios, compartir_con_doctor, usuario_ultima_edicion, usuario_creacion', 'numerical', 'integerOnly'=>true),
			array('informacion_clinica_y_terapeutica, comentarios', 'length', 'max'=>256),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, id_doctores, id_pacientes, id_status, id_unidades_responsables, fecha_captura, informacion_clinica_y_terapeutica, comentarios, requiere_factura, descuento, id_multitarifarios, compartir_con_doctor, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion', 'safe', 'on'=>'search'),
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
			'ordenTieneExamenes' => array(self::HAS_MANY, 'OrdenTieneExamenes', 'id_ordenes'),
			'idDoctores' => array(self::BELONGS_TO, 'Doctores', 'id_doctores'),
			'idMultitarifarios' => array(self::BELONGS_TO, 'Multitarifarios', 'id_multitarifarios'),
			'idPacientes' => array(self::BELONGS_TO, 'Pacientes', 'id_pacientes'),
			'idStatus' => array(self::BELONGS_TO, 'Status', 'id_status'),
			'idUnidadesResponsables' => array(self::BELONGS_TO, 'UnidadesResponsables', 'id_unidades_responsables'),
			'pagoses' => array(self::HAS_MANY, 'Pagos', 'id_ordenes'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_doctores' => 'Id Doctores',
			'id_pacientes' => 'Id Pacientes',
			'id_status' => 'Id Status',
			'id_unidades_responsables' => 'Id Unidades Responsables',
			'fecha_captura' => 'Fecha Captura',
			'informacion_clinica_y_terapeutica' => 'Informacion Clinica Y Terapeutica',
			'comentarios' => 'Comentarios',
			'requiere_factura' => 'Requiere Factura',
			'descuento' => 'Descuento',
			'id_multitarifarios' => 'Id Multitarifarios',
			'compartir_con_doctor' => 'Compartir Con Doctor',
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
		$criteria->compare('id_doctores',$this->id_doctores);
		$criteria->compare('id_pacientes',$this->id_pacientes);
		$criteria->compare('id_status',$this->id_status);
		$criteria->compare('id_unidades_responsables',$this->id_unidades_responsables);
		$criteria->compare('fecha_captura',$this->fecha_captura,true);
		$criteria->compare('informacion_clinica_y_terapeutica',$this->informacion_clinica_y_terapeutica,true);
		$criteria->compare('comentarios',$this->comentarios,true);
		$criteria->compare('requiere_factura',$this->requiere_factura);
		$criteria->compare('descuento',$this->descuento);
		$criteria->compare('id_multitarifarios',$this->id_multitarifarios);
		$criteria->compare('compartir_con_doctor',$this->compartir_con_doctor);
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
	 * @return Ordenes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function obtenerDoctores(){
		return CHtml::listData(Doctores::model()->findAll(), 'id', 'nombre');
	}
}