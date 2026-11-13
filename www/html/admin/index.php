<?php
require_once __DIR__ . '/../config.php';
    //include('../contra.php');
    session_start();
    if(empty($_SESSION["admin"]))
    {
        header("location: acceso.php");
    }
    else
    {
    /*include('../../include_videotutoriales/configpc.php');*/
        include('Smarty/libs/Smarty.class.php');
        $db = new mysqli(cotizador_config('DB_HOST'), cotizador_config('DB_USER'), cotizador_config('DB_PASSWORD'), cotizador_config('DB_NAME'));
        $html=new Smarty;
        $usuarios=array();
        $query="select * from usuarios";
        $res=$db->query($query);
        if($db->affected_rows>0)
        {
            while($fila=$res->fetch_array())
            {
                $usuarios[$fila["id"]]=array("id"=>$fila["id"], "usuario"=>$fila["usuario"],
                                             "nombre"=>$fila["nombre"], "apellido"=>$fila["apellido"]);
            }
        }
        /*echo $_SESSION["admin"];*/
        $cola="select * from usuarios where control='1'";
        $control=array();
        $resultado=$db->query($cola);
        $valor=$resultado->fetch_array();
        $control[$valor["id"]]=array("id"=>$valor["id"], "usuario"=>$valor["usuario"]);

        $query="select id, cad, dolar from parametros";
        $res=$db->query($query);
        $para=$res->fetch_array();
        $parametros[$para["id"]]=array("id"=>$para["id"], "cad"=>$para["cad"], "dolar"=>$para["dolar"]);
       
        if($valor["usuario"]=="admin" or $valor["usuario"]=="rodofox" or $valor["usuario"]=="marcefo")
        {
            $html->assign("valor",$control);
            $html->assign("usuarios",$usuarios);
            $html->assign("parametros",$parametros);
            $html->display("listado.html");
        }
        else
        {
            $html->assign("usuarios",$usuarios);
            $html->assign("valor",$control);
            $html->display("listado2.html");   
        }
                
        
    }
?>
