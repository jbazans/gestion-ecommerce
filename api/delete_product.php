<?php
	include("../config/conexion.php");
	$response=new stdClass();

	//completa la logica para que valide si el producto existe en la tabla de pedidos
	//1. Si existe, haces un cambio del estado del pedido
	//2. Si no existe, lo eliminamos
	$codpro=$_POST['codpro'];
	$sql="delete from producto
	where codpro=$codpro";
	$result=mysqli_query($con,$sql);
	if ($result) {
		$response->state=true;
		//queda pendiente eliminar la imagen del servidor
	}else{
		$response->state=true;
		$response->detail="No se puede eliminar el producto";
	}

	echo json_encode($response);