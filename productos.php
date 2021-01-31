<?php
	include('config/conexion.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Administracion | Productos</title>
	<meta charset="utf-8">
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
	<div class="modal" id="modal-producto-edit" style="display: none;">
		<div class="body-modal">
			<button class="btn-close" onclick="hide_modal('modal-producto-edit')"><i class="fa fa-times" aria-hidden="true"></i></button>
			<h3>Editar producto</h3>
			<div class="div-flex">
				<label>Código</label>
				<input type="text" id="codigo-e" disabled>
			</div>
			<div class="div-flex">
				<label>Nombre</label>
				<input type="text" id="nombre-e">
			</div>
			<div class="div-flex">
				<label>Descripción</label>
				<input type="text" id="descripcion-e">
			</div>
			<div class="div-flex">
				<label>Precio</label>
				<input type="number" id="precio-e">
			</div>
			<input type="text" id="rutimapro-aux" style="display: none;">
			<div class="div-flex">
				<label>Estado</label>
				<select id="estado-e">
					<option value="1">Activo</option>
					<option value="0">Inactivo</option>
				</select>
			</div>
			<img id="rutimapro" src="" style="width: 200px;margin: 5px auto;">
			<div class="div-flex">
				<input type="file" id="imagen-e">
			</div>
			<button onclick="update_producto()">Actualizar</button>
		</div>
	</div>
	<div class="main-container">
		<?php include("layout/_directorios.php"); ?>
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
								<button onclick="edit_product('.$row['codpro'].')"><i class="fa fa-pencil" aria-hidden="true"></i></button>
								<button onclick="delete_product('.$row['codpro'].')"><i class="fa fa-trash" aria-hidden="true"></i></button>
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
			fd.append('imagen',document.getElementById('imagen').files[0]);
			let request=new XMLHttpRequest();
			request.open('POST','api/producto_save.php',true);
			request.onload=function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					console.log(response);
					if (response.state) {
						alert("Producto guardado");
						window.location.reload();
					}else{
						alert(response.detail);
					}
				}
			}
			request.send(fd);
		}
		function delete_product(codpro){
			var c=confirm("Estas seguro de eliminar el producto de codigo "+codpro+"?");
			if (c) {
				let fd=new FormData();
				fd.append('codpro',codpro);
				let request=new XMLHttpRequest();
				request.open('POST','api/delete_product.php',true);
				request.onload=function(){
					if (request.readyState==4 && request.status==200) {
						let response=JSON.parse(request.responseText);
						console.log(response);
						if (response.state) {
							alert("Producto eliminado");
							window.location.reload();
						}else{
							alert(response.detail);
						}
					}
				}
				request.send(fd);
			}
		}

		function edit_product(codpro){
			let fd=new FormData();
			fd.append('codpro',codpro);
			let request=new XMLHttpRequest();
			request.open('POST','api/get_product.php',true);
			request.onload=function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					console.log(response);
					document.getElementById("codigo-e").value=codpro;
					document.getElementById("nombre-e").value=response.product.nompro;
					document.getElementById("descripcion-e").value=response.product.despro;
					document.getElementById("precio-e").value=response.product.prepro;
					document.getElementById("estado-e").value=response.product.estado;
					document.getElementById("rutimapro").src="../sistema-ecommerce/assets/products/"+response.product.rutimapro;
					document.getElementById("rutimapro-aux").value=response.product.rutimapro;
					show_modal('modal-producto-edit');
					//imagen-e
				}
			}
			request.send(fd);
		}

		function update_producto(){
			let fd=new FormData();
			fd.append('codigo',document.getElementById('codigo-e').value);
			fd.append('nombre',document.getElementById('nombre-e').value);
			fd.append('descripcion',document.getElementById('descripcion-e').value);
			fd.append('precio',document.getElementById('precio-e').value);
			fd.append('estado',document.getElementById('estado-e').value);
			fd.append('imagen',document.getElementById('imagen-e').files[0]);
			fd.append('rutimapro',document.getElementById("rutimapro-aux").value);
			let request=new XMLHttpRequest();
			request.open('POST','api/producto_update.php',true);
			request.onload=function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					console.log(response);
					if (response.state) {
						alert("Producto actualizado");
						window.location.reload();
					}else{
						alert(response.detail);
					}
				}
			}
			request.send(fd);
		}
	</script>
</body>
</html>