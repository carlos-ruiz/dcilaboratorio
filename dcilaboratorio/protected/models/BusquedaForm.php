<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class BusquedaForm extends CFormModel
{
	public $fecha_final;
	public $fecha_inicial;
	public $id_pacientes;
	public $id_doctores;
	public $id_multitarifarios;
	public $dia;
	public $mes;
	public $año;
	public $semana;
	public $hora;
	public $folio;
	public $nombre_paciente;
	public $unidad;
	public $doctor;
	public $id_paciente;
	public $clave_examen;
	public $costo;
	public $porcentaje_descuento;
	public $monto_descuento;
	public $tarifa;
	public $estatus;

	public $check;
	public $id_examen;
	public $id_estatus;


	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('fecha_inicial, fecha_final', 'required'),
			// boolean
			array('dia, mes, año, semana, id_paciente, hora, folio, nombre_paciente, unidad, doctor, id_examen, costo, porcentaje_descuento, monto_descuento, tarifa, id_estatus', 'boolean'),
			// numerical
			array('id_doctores, id_pacientes, id_doctores, id_multitarifarios, clave_examen, estatus', 'numerical', 'integerOnly'=>true),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'fecha_inicial'=>'Fecha Inicial',
			'fecha_final'=>'Fecha Final',
			'id_pacientes'=>'Paciente',
			'id_doctores'=>'Doctor',
			'id_multitarifarios'=>'Multitarifario',
			'id_examenes'=>'Examen',
			'dia'=>'Día',
			'mes'=>'Mes',
			'año'=>'Año',
			'semana'=>'Semana',
			'hora'=>'Hora',
			'folio'=>'Folio',
			'nombre_paciente'=>'Nombre del paciente',
			'unidad'=>'Unidad Resp.',
			'doctor'=>'Doctor',
			'id_examen'=>'Examen',
			'costo'=>'Costo',
			'porcentaje_descuento'=>'% Desc',
			'monto_descuento'=>'Monto descuento',
			'tarifa'=>'Tarifa',
			'estatus'=>'Estatus',
			'id_estatus'=>'Estatus',
		);
	}

public function generar()
{

}

/* Criteria es para lo q vas a mostrar
public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_doctores',$this->id_doctores);
		$criteria->compare('id_status',$this->id_status);
		$criteria->compare('id_unidades_responsables',$this->id_unidades_responsables);
		$criteria->compare('fecha_captura',$this->fecha_captura,true);
		$criteria->compare('informacion_clinica_y_terapeutica',$this->informacion_clinica_y_terapeutica,true);
		$criteria->compare('comentarios',$this->comentarios,true);
		$criteria->compare('requiere_factura',$this->requiere_factura);
		$criteria->compare('descuento',$this->descuento);
		$criteria->compare('id_multitarifarios',$this->id_multitarifarios);
		$criteria->compare('compartir_con_doctor',$this->compartir_con_doctor);
		$criteria->compare('costo_emergencia',$this->costo_emergencia,true);
		$criteria->compare('ultima_edicion',$this->ultima_edicion,true);
		$criteria->compare('usuario_ultima_edicion',$this->usuario_ultima_edicion);
		$criteria->compare('creacion',$this->creacion,true);
		$criteria->compare('usuario_creacion',$this->usuario_creacion);
		if(Yii::app()->user->getState('perfil')=='Paciente'){
			$criteria->with=array('ordenFacturacion');
			$criteria->compare('ordenFacturacion.id_usuarios',Yii::app()->user->id);
		}
		if(Yii::app()->user->getState('perfil')=='Doctor'){	
			$criteria->compare('id_doctores',Yii::app()->user->getState('id_persona'));
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));
	}





	
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function search()
	{


		if(!$this->hasErrors())
		{

			//Crear una instancia del formulario para obtener los valores ingresados por post
			
			$model=new BusquedaForm;
			//echo 'lalalala'+$model['fecha_inicial'];

			//Cómo hacer relaciones o cruzar entre dos modelos: ORdenes tiene exam y como sabre el grupo?
			/*$criteria->addBetweenCondition('creacion', $model['fecha_inicial'], $model['fecha_fin']);

			$model=Ordenes::model()->findAllByAttributes(array(
			'id_doctores'=>$idDoctores,
			'id_multitarifarios'=>$idMultitarifarios,			
			),$criteria);

			*/
		}
		return array();
	}

	


	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	

}
