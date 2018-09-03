<?php

require_once '../datos/Conexion.clase.php';

class Articulo extends Conexion {
    
    public function listar() {
        try {
            $sql = "
                select
                    a.codigo_articulo,
                    a.nombre_articulo,
                    a.precio_venta,
                    a.descripcion,
                    c.nombre_categoria,
                    COALESCE(sum(v.valor),0) valoracion_total,
                    count(v.codigo_articulo) cantidad_votos
                from
                    articulo a
                    inner join categoria c on ( a.codigo_categoria = c.codigo_categoria )
                    left join valoracion v on (v.codigo_articulo=a.codigo_articulo)
		group by a.codigo_articulo,
                    a.nombre_articulo,
                    a.precio_venta,
                    a.descripcion,
                    c.nombre_categoria
                order by
                        2
                ";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
    }
    
    public function obtenerFoto($codigo) {
        $foto = "../fotos-articulos/".$codigo;

        if (file_exists( $foto . ".png" )){
            $foto = $foto . ".png";

        }else if (file_exists( $foto . ".PNG" )){
            $foto = $foto . ".PNG";

        }else if (file_exists( $foto . ".jpg" )){
            $foto = $foto . ".jpg";

        }else if (file_exists( $foto . ".JPG" )){
            $foto = $foto . ".JPG";

        }else{
            $foto = "none";
        }

        if ($foto == "none"){
            return $foto;
        }else{
            return Funciones::$DIRECCION_WEB_SERVICE . $foto;
        }

    }
    
}
