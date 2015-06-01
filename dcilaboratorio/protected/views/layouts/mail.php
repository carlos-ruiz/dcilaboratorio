<!DOCTYPE html>
<html>
	<head>
		<style>
			* {
				margin: 0;
				padding: 0;
			}
			body {
				background-color:white;
				font-family: 'Century Gothic', CenturyGothic, AppleGothic, sans-serif;
			}
			h1 {
				color:#3B3F51;
			}
			p {
				font-size: 12pt;
			}
			.encabezado {
				background-color:#3B3F51;
				height: 80;
				color: white;
			}

			.img{
				padding-top: 10px;
				padding-left: 10px;	
			}
			.importante{
				font-size: 16pt;
				color:#1E90FF;
			}
			.margen{
				padding-left: 100px;	
			}

			.header, .footer {
				background-color:#3B3F51;
				color: white;
			}

			.header h1 {
				color: white;
				display: inline-block;
			}

			.align-center {
				text-align: center;
			}

			table {
				width: 100%;
			}
			td {
				white-space: nowrap;
			}

		</style>
	</head>
	
	<body>
		<div class="header">
			<table>
				<tr>
					<td>
						<a href="http://www.dcilaboratorio.com/" style="float:left;">
							<img class="img" src="dci.png" alt="logo"  height="50" width="60" class="logo-default" alt="dcilaboratorio.com" />
						</a>
					</td>
					<td class="align-center" width="100%">
						<h1><?php echo CHtml::encode(Yii::app()->name); ?></h1>
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
		<div class="footer">
			<p class="align-center"> ¡DCI Laboratorio agradece tu peferencia! <br/>
				Para cualquier aclaración comunicarse al: (443) 3-22-11-22.
			</p>
		</div>
	</body>
</html>