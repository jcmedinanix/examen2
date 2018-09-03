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
        $resultado = $objV->regitrarVotacion();
        if($resultado){
            Funciones::imprimeJSON(200, "Gracias por tu voto.", "");
        }else{
            Funciones::imprimeJSON(500, "Error en la votación, intentalo más tarde.", "");
        }
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}