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
	<div class="modal" id="modal-producto" style="display: none;">
		<div class="body-modal">
			<button class="btn-close" onclick="hide_modal('modal-producto')"><i class="fa fa-times" aria-hidden="true"></i></button>
			<h3>Añadir producto</h3>
			<input type="text" id="codigo" style="display: none;">
			<div class="div-flex">
				<label>Nombre</label>
				<input type="text" id="nombre">
			</div>
			<div class="div-flex">
				<label>Descripción</label>
				<input type="text" id="descripcion">
			</div>
			<div class="div-flex">
				<label>Precio</label>
				<input type="number" id="precio">
			</div>
			<div class="div-flex">
				<label>Estado</label>
				<select id="estado">
					<option value="1">Activo</option>
					<option value="0">Inactivo</option>
				</select>
			</div>
			<div class="div-flex">
				<input type="file" id="imagen">
			</div>
			<button onclick="save_producto()">Guardar</button>
		</div>
	</div>
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
			<button class="mt10" onclick="show_modal('modal-producto')">Agregar nuevo</button>
		</div>
	</div>
	<script type="text/javascript">
		function show_modal(id){
			document.getElementById(id).style.display="block";
		}
		function hide_modal(id){
			document.getElementById(id).style.display="none";
		}
		function save_producto(){
			let fd=new FormData();
			fd.append('codigo',document.getElementById('codigo').value);
			fd.append('nombre',document.getElementById('nombre').value);
			fd.append('descripcion',document.getElementById('descripcion').value);
			fd.append('precio',document.getElementById('precio').value);
			fd.append('estado',document.getElementById('estado').value);
			fd.append('imagen',document.getElementById('imagen').value);
			let request=new XMLHttpRequest();
			request.open('POST','api/producto_save.php',true);
			request.onload=function(){
				console.log(request);
			}
			request.send(fd);
		}
	</script>
</body>
</html>