<?php

require_once '../logica/Valoracion.clase.php';
require_once '../util/funciones/Funciones.clase.php';
require_once 'token.validar.php';

if ( ! isset($_POST["token"])){
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}

//Recibir el token
$token = $_POST["token"];
$codigoUsuario = $_POST["p_codigo_usuario"];
$codigoArticulo = $_POST["p_codigo_articulo"];
$valor = $_POST["p_valor"];

try {
    //Validar el token
    if (validarToken($token)){
        $objV = new Valoracion();
        $objV->setCodigoArticulo($codigoArticulo);
        $objV->setCodigoUsuario($codigoUsuario);
        $objV->setValor($valor);

        $resultado = $objV->nrodeRegistros();
        $registros=count($resultado["valor"]);
        if($registros==0){
              $resultado = $objV->regitrarVotacion();
            }else{
              $resultado = $objV->actualizarVotacion();  
            }
        if($resultado){
            Funciones::imprimeJSON(200, "Gracias por tu voto." . $registros . " y resultado es ". $resultado["valor"] , "");
        }else{
            Funciones::imprimeJSON(500, "Error en la votación, intentalo más tarde.", "");
        }
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}