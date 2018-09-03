<?php

require_once '../logica/Sesion.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (!isset($_POST["p_email"])  ||  !isset($_POST["p_clave"])){
    Funciones::imprimeJSON(500, "Falta completar datos requeridos", "");
    exit;
}

$email = $_POST["p_email"];
$clave = $_POST["p_clave"];

try {
    $objSesion = new Sesion();
    $objSesion->setEmail($email);
    $objSesion->setClave($clave);
    $resultado = $objSesion->validarSesion();
    
    //Obtener el código del usuario para ubicar la foto correspondiente
    $codigo_usuario = $resultado["codigo_usuario"];
    
    //Obtener la foto del usuario
    $foto = $objSesion->obtenerFoto($codigo_usuario);
    
    //Agregar la foto a la variable $resultado
    $resultado["foto"] = $foto;
    
    //GENERAR EL TOKEN DE SEGURIDAD
    require_once'./token.generar.php';
    $token = generarToken(null,60*60);
    $resultado["token"] = $token;
    
    
    //Preguntar por el estado que ha devuelto la función de la BD
    if ($resultado["estado"]==200){
        Funciones::imprimeJSON(200, "Bienvenido a la aplicación", $resultado);
    }else{
        //$resultado["nombre_usuario"] = Mensaje de error que viene de la función que esta en la BD
        Funciones::imprimeJSON(500, $resultado["nombre_usuario"], "");
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

