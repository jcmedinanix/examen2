<?php

require_once '../logica/Articulo.clase.php';
require_once '../util/funciones/Funciones.clase.php';

require_once 'token.validar.php';

if ( ! isset($_POST["token"])){
    Funciones::imprimeJSON(500, "Debe especificar un token", "");
    exit();
}

//Recibir el token
$token = $_POST["token"];

try {
    //Validar el token
    if (validarToken($token)){
        $objArti = new Articulo();
        $resultado = $objArti->listar();
        
        //Obtener la foto de cada artículo
        for ($i = 0; $i < count($resultado); $i++) {
            $codigo = $resultado[$i]["codigo_articulo"];
            $foto = $objArti->obtenerFoto($codigo);
            //Asignar la foto al array $resultado
            $resultado[$i]["foto"] = $foto;
        }
        //Mostrar la lista de artículos
        Funciones::imprimeJSON(200, "", $resultado);
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
