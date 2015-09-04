<?php

/**
 * This is the model class for table "examenes".
 *
 * The followings are the available columns in table 'examenes':
 * @property integer $id
 * @property string $clave
 * @property string $nombre
 * @property string $descripcion
 * @property integer $duracion_dias
 * @property string $indicaciones_paciente
 * @property string $indicaciones_laboratorio
 * @property string $ultima_edicion
 * @property integer $usuario_ultima_edicion
 * @property string $creacion
 * @property integer $usuario_creacion
 *
 * The followings are the available model relations:
 * @property DetallesExamen[] $detallesExamens
 * @property GrupoTieneExamenes[] $grupoTieneExamenes
 * @property TarifasActivas[] $tarifasActivases
 */
class Examenes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'examenes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('clave, nombre, duracion_dias, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion', 'required'),
			array('duracion_dias', 'numerical', 'integerOnly'=>true, 'min'=>0),
			array('clave,nombre', 'unique'),
			array('duracion_dias, usuario_ultima_edicion, usuario_creacion', 'numerical', 'integerOnly'=>true),
			array('clave, nombre, tecnica', 'length', 'max'=>45),
			array('descripcion, indicaciones_paciente, indicaciones_laboratorio', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, clave, nombre, descripcion, tecnica, duracion_dias, indicaciones_paciente, indicaciones_laboratorio, ultima_edicion, usuario_ultima_edicion, creacion, usuario_creacion', 'safe', 'on'=>'search'),
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
			'detallesExamenes' => array(self::HAS_MANY, 'DetallesExamen', 'id_examenes'),
			'grupoTieneExamenes' => array(self::HAS_MANY, 'GrupoTieneExamenes', 'id_examenes'),
			'tarifasActivases' => array(self::HAS_MANY, 'TarifasActivas', 'id_examenes'),
			'precio' => array(self::HAS_MANY, 'OrdenPrecioExamen', 'id_examenes'),
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
			'nombre' => 'Determinación',
			'descripcion' => 'Descripción',
			'duracion_dias' => 'Duración en días',
			'indicaciones_paciente' => 'Indicaciones Paciente',
			'indicaciones_laboratorio' => 'Indicaciones Laboratorio',
			'ultima_edicion' => 'Ultima Edicion',
			'usuario_ultima_edicion' => 'Usuario Ultima Edicion',
			'creacion' => 'Creacion',
			'usuario_creacion' => 'Usuario Creacion',
			'tecnica'=>'Método analítico',
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
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('tecnica',$this->tecnica,true);
		$criteria->compare('duracion_dias',$this->duracion_dias);
		$criteria->compare('indicaciones_paciente',$this->indicaciones_paciente,true);
		$criteria->compare('indicaciones_laboratorio',$this->indicaciones_laboratorio,true);
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
	 * @return Examenes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getAll(){
		return $this->model()->findAll('activo=1');
	}

	public function findExamenesInIds($ids){
		if(sizeof($ids)>0){
			$in='(';
			for ($i=0; $i < sizeof($ids); $i++) {
				$in.=$i!=(sizeof($ids)-1)?'?,':'?)';
			}
			return $this->model()->findAll('id in '.$in.' AND activo = 1',$ids);
		}
		else{
			return array();
		}
	}

	public function selectList(){
		$examenes = $this->model()->findAll('activo=1');
		$data = array(null=>"--Seleccione--");
		foreach ($examenes as $examen) {
			$data[$examen->id]=$examen->nombre;
		}
		return $data;
	}

	public function selectListWithClave(){
		$examenes = $this->model()->findAll('activo=1');
		$data = array(null=>"--Seleccione--");
		foreach ($examenes as $examen) {
			if(sizeof($examen->detallesExamenes)>0 && $examen->tieneResultadosActivos())
				$data[$examen->id]=$examen->clave." - ".$examen->nombre;
		}
		return $data;
	}

	public function tieneResultadosActivos(){
		foreach ($this->detallesExamenes as $detalle) {
			if($detalle->activo==1){
				return true;
			}
		}
		return false;
	}

}