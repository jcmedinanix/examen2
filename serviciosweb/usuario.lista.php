<?php
require_once '../logica/Usuario.clase.php';
require_once '../util/funciones/Funciones.clase.php';
try {

        $obj = new Usuario();
        $resultado = $obj->listarUsuario();
        //esto ya imprime en JSON
        Funciones::imprimeJSON(200, "", $resultado);
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
