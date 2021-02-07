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
		<?php include("layout/_directorios.php"); ?>
		<div class="body-page">
			<h2>Inicio / Pendientes de despacho</h2>
			<table class="mt10">
				<thead>
					<tr>
						<th>Código</th>
						<th>Usuario</th>
						<th>Producto</th>
						<th>Fecha</th>
						<th>Estado</th>
						<th>Dirección</th>
						<th>Teléfono</th>
						<th>Opciones</th>
					</tr>
				</thead>				
				<tbody>
					<?php
							$sql="SELECT ped.*,usu.*,pro.*,
							CASE WHEN ped.estado=2
							THEN 'Por pagar'
							ELSE 
								CASE WHEN ped.estado=3
									THEN 'Por entregar'
									ELSE
									CASE WHEN ped.estado=4
										THEN 'En camino'
										ELSE 'Otro'
									END
								END
							END estadotexto, ped.estado estadoped
							from pedido ped
							inner  join usuario usu
							on ped.codusu=usu.codusu
							inner  join producto pro
							on ped.codpro=pro.codpro
							where ped.estado=2 or ped.estado=3 or ped.estado=4";
						$resultado=mysqli_query($con,$sql);
						while ($row=mysqli_fetch_array($resultado)) {
							echo 
					'<tr>
						<td>'.$row['codped'].'</td>
						<td>'.$row['codusu'].' - '.$row['nomusu'].'</td>
						<td>'.$row['codpro'].' - '.$row['nompro'].'</td>
						<td>'.$row['fecped'].'</td>
						<td>'.$row['estadotexto'].'</td>
						<td>'.$row['dirusuped'].'</td>
						<td>'.$row['telusuped'].'</td>';
						if ($row['estadoped']==4) {
							echo
						'<td class="td-option">
							<button onclick="confirmar_entrega('.$row['codped'].')">Entregado</button>
						</td>';	
						}else{
							echo
						'<td class="td-option">
							<button onclick="despachado('.$row['codped'].')">Despachar</button>
						</td>';
						}
						echo
					'</tr>';
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<script type="text/javascript">
		function show_modal(id){
			document.getElementById(id).style.display="block";
		}
		function hide_modal(id){
			document.getElementById(id).style.display="none";
		}
		function despachado(codped){
			let fd=new FormData();
			fd.append('codped',codped);
			let request=new XMLHttpRequest();
			request.open('POST','api/pedido_confirm.php',true);
			request.onload=function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					console.log(response);
					if (response.state) {
						window.location.reload();
					}else{
						alert(response.detail);
					}
				}
			}
			request.send(fd);
		}
		function confirmar_entrega(codped){
			let fd=new FormData();
			fd.append('codped',codped);
			let request=new XMLHttpRequest();
			request.open('POST','api/pedido_confirm_entrega.php',true);
			request.onload=function(){
				if (request.readyState==4 && request.status==200) {
					let response=JSON.parse(request.responseText);
					console.log(response);
					if (response.state) {
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