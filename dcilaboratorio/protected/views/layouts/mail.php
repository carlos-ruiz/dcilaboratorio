<!DOCTYPE html>
<html>	
	<body>
		<div style="background-color:#3B3F51; color: white;">
			<table>
				<tr>
					<td>
						<a href="http://www.dcilaboratorio.com/" style="float:left;">
							<img class="img" src="dci.png" alt="logo"  height="50" width="60" class="logo-default" alt="dcilaboratorio.com" />
						</a>
					</td>
					<td style="text-align: center;" width="100%">
						<h1 style="color: white; display: inline-block;"><?php echo CHtml::encode(Yii::app()->name); ?></h1>
					</td>
				</tr>
			</table>
		</div>
		<br />
		<section class="contenido">
			<h2 style="color:#777;font-size:16px;padding-top:5px;">
				<?php if(isset($data['description'])) echo $data['description'];  ?>
			</h2>
			<p>
				<?php echo $content ?>
			</p>
		</section>
		<div style="background-color:#3B3F51; color: white;">
			<p style="text-align: center;"> “Diagnóstico Clínico Integral agradece su confianza y preferencia para utilizar nuestros servicios, ponemos a su disposición  un equipo humano y tecnológico de vanguardia para brindarle seguridad y calidad en nuestras determinaciones. La consulta o impresión de sus resultados puede realizarla en el sitio www.dcilaboratorio.com con las claves de usuario y contraseña indicadas.” <br/>
				Para cualquier aclaración comunicarse al: (443) 3-22-11-22.
			</p>
		</div>
	</body>
</html>