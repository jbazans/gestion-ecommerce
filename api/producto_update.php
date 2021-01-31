<?php
	include("../config/conexion.php");
	$response=new stdClass();

	//$response->state=true;
	$codpro=$_POST['codigo'];
	$nompro=$_POST['nombre'];
	$despro=$_POST['descripcion'];
	$prepro=$_POST['precio'];
	$estado=$_POST['estado'];
	$rutimapro=$_POST['rutimapro'];

	if(isset($_FILES['imagen'])){
		$nombre_imagen = date("YmdHis").".jpg";  
		$sql="update producto set nompro='$nompro',despro='$despro',
		estado=$estado,prepro=$prepro,rutimapro='$nombre_imagen'
		where codpro=$codpro";
		$result=mysqli_query($con,$sql);
		if ($result) {
			if(move_uploaded_file($_FILES['imagen']['tmp_name'], "../../sistema-ecommerce/assets/products/".$nombre_imagen)){
				$response->state=true;
				unlink("../../sistema-ecommerce/assets/products/".$rutimapro);
			}else{
				$response->state=false;
				$response->detail="Hubo un error al cargar la imagen";
			}
		}else{
			$response->state=false;
			$response->detail="No se pudo actualizar el producto";
		}
	}else{
		$sql="update producto set nompro='$nompro',despro='$despro',
		estado=$estado,prepro=$prepro
		where codpro=$codpro";
		$result=mysqli_query($con,$sql);
		if ($result) {
			$response->state=true;
		}else{
			$response->state=false;
			$response->detail="No se pudo actualizar los datos";
		}
	}

	echo json_encode($response);