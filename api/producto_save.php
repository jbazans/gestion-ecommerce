<?php
	include("../config/conexion.php");
	$response=new stdClass();

	//$response->state=true;
	$codigo=$_POST['codigo'];
	$nombre=$_POST['nombre'];
	$descripcion=$_POST['descripcion'];
	$precio=$_POST['precio'];
	$estado=$_POST['estado'];

	if ($nombre=="") {
		$response->state=false;
		$response->detail="Falta el nombre";
	}else{
		if ($descripcion=="") {
			$response->state=false;
			$response->detail="Falta la descripcion";
		}else{
			if(isset($_FILES['imagen'])){
				//TU TAREA ES CAPTURAR LA FECHA Y HORA DEL SISTEMA
				//$nombre_imagen="20201011090730.jpg";
				$nombre_imagen = date("YmdHis").".jpg";  
				$sql="INSERT INTO producto (nompro,despro,prepro,estado,rutimapro)
				VALUES ('$nombre','$descripcion',$precio,$estado,'$nombre_imagen')";
				$result=mysqli_query($con,$sql);
				if ($result) {
					//RECUERDA QUE MUEVE QUE NECESITES MENOS RETORNOS DE DIRECTORIO, es decir el "../"
					if(move_uploaded_file($_FILES['imagen']['tmp_name'], "../../sistema-ecommerce/assets/products/".$nombre_imagen)){
						$response->state=true;
					}else{
						$response->state=false;
						$response->detail="hubo un error al cargar la imagen";
					}
				}else{
					$response->state=false;
					$response->detail="No se pudo guardar el producto";
				}
			}else{
				$response->state=false;
				$response->detail="Falta la imagen";
			}
		}
	}

	echo json_encode($response);