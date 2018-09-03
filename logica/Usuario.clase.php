<?php

require_once '../datos/Conexion.clase.php';

class Usuario extends Conexion{
    public function listarUsuario() {
    try{
     
            $sql = "
                    select  email                
                from
                    usuario                    
		order by 1 asc
                ";
            //suba otra vez este archivo
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    }
    
    

