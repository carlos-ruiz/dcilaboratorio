<script type="text/javascript">
	function block(target) {
        Metronic.blockUI({
            target: '#'+target,
            animate: true
        });
    }

    function unblock(target){

        Metronic.unblockUI('#'+target);
    }

    function send()
	{
	    var data=$("#email-form").serialize();
	    block("modal-body");
	  	$.ajax({
		    type: 'POST',
		    url: $("#email-form").attr('action'),
		    data:data,
			success:function(data){	
				var error=data.substring(0,1);
				//alert(error);
				if(error=='1'){//Ocurrio un error de envío
					$("#modal-body").html(data.substring(1));
				}else if(error=='2'){//Ocurrio un error de validacion	
					$("#modal-body").html(data.substring(1));
			    } else{
			    	$("#modal").modal("hide");
			    }
			},
		    error: function(data,status,message) { 
		         html=data.responseText.replace('<h1>Exception</h1>','').replace('<p>','').replace('</p>','');
		         html=html.substring(0,html.indexOf("(C:")-1);
		         $("#modal-body").html(html);
		    },
		 
		  	dataType:'html'
	  	});
	}

	$("#modalAceptarEmail").click(function(evt) {
		send();
	});
</script>


<?php
/* @var $this OrdenesController */
/* @var $model Ordenes */

 if(Yii::app()->user->getState('perfil')=="Administrador") {
 	echo $this->renderPartial('_viewAdministrador',array(
								'model'=>$model,
								'paciente'=>$paciente,
								'pagos'=>$pagos,
								'datosFacturacion'=>$datosFacturacion,
								'examenes'=>$examenes,
								'ordenExamenesModel'=>$ordenExamenesModel,
								'ordenGruposModel'=>$ordenGruposModel,
								'ordenGrupotesModel'=>$ordenGrupotesModel,
								)
					 		);
 }
 if(Yii::app()->user->getState('perfil')=="Doctor") {
 	echo $this->renderPartial('_viewDoctor',array(
								'model'=>$model,
								'paciente'=>$paciente,
								'pagos'=>$pagos,
								'datosFacturacion'=>$datosFacturacion,
								'examenes'=>$examenes,
								'ordenExamenesModel'=>$ordenExamenesModel,
								'ordenGruposModel'=>$ordenGruposModel,
								'ordenGrupotesModel'=>$ordenGrupotesModel,
								)
					 		);
 }
 if(Yii::app()->user->getState('perfil')=="Paciente") {
 	echo $this->renderPartial('_viewPaciente',array(
								'model'=>$model,
								'paciente'=>$paciente,
								'pagos'=>$pagos,
								'datosFacturacion'=>$datosFacturacion,
								'examenes'=>$examenes,
								'ordenExamenesModel'=>$ordenExamenesModel,
								'ordenGruposModel'=>$ordenGruposModel,
								'ordenGrupotesModel'=>$ordenGrupotesModel,
								)
					 		);
 }

?>
