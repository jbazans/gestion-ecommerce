<?php
	include("../config/conexion.php");
	$response=new stdClass();

	$codpro=$_POST['codpro'];
	$sql="select * from pedido where codpro=$codpro";
	$result=mysqli_query($con,$sql);
	$row=mysqli_fetch_array($result);
	$contador=mysqli_num_rows($result);
	if ($contador>0) {
		$sql="update producto set estado=0 where codpro=$codpro";
		$result=mysqli_query($con,$sql);
		if ($result) {
			$response->state=true;
		}else{
			$response->state=false;
			$response->detail="No se puede eliminar el producto";
		}
	}else{
		$sql="select rutimapro from producto where codpro=$codpro";
		$result=mysqli_query($con,$sql);
		$row=mysqli_fetch_array($result);
		$rutimapro=$row['rutimapro'];

		$sql="delete from producto
		where codpro=$codpro";
		$result=mysqli_query($con,$sql);
		if ($result) {
			$response->state=true;
			//recuerda que debes redireccionar al nombre de proyecto correcto
			// ejm: sistema-ecommerce-master
			unlink("../../sistema-ecommerce/assets/products/".$rutimapro);
		}else{
			$response->state=false;
			$response->detail="No se puede eliminar el producto";
		}
	}

	echo json_encode($response);