<?php
	include("../config/conexion.php");
	$response=new stdClass();

	$codped=$_POST['codped'];
	$sql="UPDATE pedido set estado=4
	where codped=$codped";
	$result=mysqli_query($con,$sql);
	if ($result) {
		$response->state=true;
	}else{
		$response->state=true;
		$response->detail="No se actualizo el estado";
	}

	echo json_encode($response);