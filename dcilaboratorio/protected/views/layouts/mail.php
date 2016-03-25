<!DOCTYPE html>
<html>	
	<body>
		<div style="">
			<table>
				<tr>
					<td>
						<a href="http://www.dcilaboratorio.com/" style="float:left;">
							<img class="img" src="logo.png" alt="logo"  height="50" width="60" class="logo-default" alt="dcilaboratorio.com" />
						</a>
					</td>
					<td style="text-align: center;" width="100%">
						<h1 style="display: inline-block;"><?php echo CHtml::encode(Yii::app()->name); ?></h1>
					</td>
				</tr>
			</table>
		</div>
		<hr style="border: solid 2px #3B3F51;">
		<hr style="border: solid 1px #3B3F51;">
		<br />
		<section class="contenido">
			<h2 style="color:#777;font-size:16px;padding-top:5px;">
				<?php if(isset($data['description'])) echo $data['description'];  ?>
			</h2>
			<p>
				<?php echo $content ?>
			</p>

			<table>
				<tr>
					<td>
						<h5  class="heading" style="color:#1e90ff ">Unidad Chapultepec</h5>
						General Nicolás Bravo No. 170
						<br />Colonia Chapultepec Norte
						<br />Código Postal 58260
						<br />Teléfono Fax. (443) 232 0166
						<br />Lunes a Sábado de 07:00 a 20:00 hrs.
						<br />Domingo 08:00 a 14:00 hrs.
					</td>
					<td>
						<h5  class="heading" style="color:#1e90ff ">Unidad Cancerología</h5>
						Francisco M. Díaz No. 145
						<br />Fracc. Ex Gobernador Gildardo Magaña
						<br />Código Postal 58149
						<br />Tel. Fax. (443) 232 01 65
						<br />Lunes a Sábado de 07:00 a 15:00 hrs.
					</td>
					<td>
						<h5  class="heading" style="color:#1e90ff ">Unidad Amado Nervo</h5>
						Amado Nervo No. 392-4
						<br />Colonia Centro
						<br />Código Postal 58000
						<br />Teléfono Fax. (443) 326 98 91
						<br />Lunes a Sábado de 07:00 a 15:00 hrs.
					</td>
				</tr>
			</table>
		</section>
		<div style="background-color:#3B3F51; color: white;">
			<p style="text-align: center;"> “Diagnóstico Clínico Integral agradece su confianza y preferencia para utilizar nuestros servicios, ponemos a su disposición  un equipo humano y tecnológico de vanguardia para brindarle seguridad y calidad en nuestras determinaciones. La consulta o impresión de sus resultados puede realizarla en el sitio www.dcilaboratorio.com con las claves de usuario y contraseña indicadas.” <br/>
				Para cualquier aclaración comunicarse al: (443) 3-22-11-22.
			</p>
		</div>
	</body>
</html>