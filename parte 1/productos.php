<?php
	include('config/conexion.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Administracion | Productos</title>
	<link rel="stylesheet" type="text/css" href="css/index.css">
	<link rel="stylesheet" type="text/css" href="font-awesome-4.7.0/css/font-awesome.min.css">
</head>
<body>
	<div class="main-container">
		<div class="body-nav-bar">
			<img src="assets/web/logo.png">
			<center>
				<h3>Administrador</h3>
			</center>
			<ul class="mt10">
				<li><a href="main.php">Inicio</a></li>
				<li><a href="productos.php">Productos</a></li>
				<li><a href="index.php">Salir</a></li>
			</ul>
		</div>
		<div class="body-page">
			<h2>Mis productos</h2>
			<table class="mt10">
				<thead>
					<tr>
						<th>Código</th>
						<th>Nombre</th>
						<th>Descripción</th>
						<th>Precio</th>
						<th class="td-option">Opciones</th>
					</tr>
				</thead>				
				<tbody>
					<?php
						$sql="SELECT * from producto";
						$resultado=mysqli_query($con,$sql);
						while ($row=mysqli_fetch_array($resultado)) {
							echo 
					'<tr>
						<td>'.$row['codpro'].'</td>
						<td>'.$row['nompro'].'</td>
						<td>'.$row['despro'].'</td>
						<td>'.$row['prepro'].'</td>
						<td class="td-option">
							<div class="div-flex div-td-button">
								<button><i class="fa fa-pencil" aria-hidden="true"></i></button>
								<button><i class="fa fa-trash" aria-hidden="true"></i></button>
							</div>
						</td>
					</tr>';
						}
					?>
				</tbody>
			</table>
			<button class="mt10">Agregar nuevo</button>
		</div>
	</div>
</body>
</html>