<?php

require_once '../datos/Conexion.clase.php';

class Valoracion extends Conexion {
    
    private $codigoValoracion;
    private $codigoUsuario;
    private $codigoArticulo;
    private $valor;
    
    function getCodigoValoracion() {
        return $this->codigoValoracion;
    }

    function getCodigoUsuario() {
        return $this->codigoUsuario;
    }

    function getCodigoArticulo() {
        return $this->codigoArticulo;
    }

    function getValor() {
        return $this->valor;
    }

    function setCodigoValoracion($codigoValoracion) {
        $this->codigoValoracion = $codigoValoracion;
    }

    function setCodigoUsuario($codigoUsuario) {
        $this->codigoUsuario = $codigoUsuario;
    }

    function setCodigoArticulo($codigoArticulo) {
        $this->codigoArticulo = $codigoArticulo;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    public function regitrarVotacion() {
        $respuesta=0;
        try {
           $sql = "INSERT INTO valoracion(                    
                    codigo_usuario, 
                    codigo_articulo, 
                    valor
                    )
                   VALUES (                    
                    :p_codigo_usuario, 
                    :p_codigo_articulo, 
                    :p_valor
                        )";
           
           $sentencia = $this->dblink->prepare($sql);
           $sentencia->bindParam(":p_codigo_usuario", $this->getCodigoUsuario());
           $sentencia->bindParam(":p_codigo_articulo", $this->getCodigoArticulo());
           $sentencia->bindParam(":p_valor", $this->getValor());
           $respuesta = $sentencia->execute();       
           return $respuesta;
       } catch (Exception $exc) {
           throw $exc;
           
       }
        
    }
    


}
