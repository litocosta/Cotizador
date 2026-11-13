<?php
require_once __DIR__ . '/config.php';
    //include('contra.php');
    session_start();
   
    if(empty($_SESSION["admin"]))
    {
        header("location: acceso.php");
    }
    else
    {
        include('Smarty/libs/Smarty.class.php');
        $db = new mysqli(cotizador_config('DB_HOST'), cotizador_config('DB_USER'), cotizador_config('DB_PASSWORD'), cotizador_config('DB_NAME'));
        //$query = "Update solicitud_compra set cambio='' where cambio='s'";
        //$db->query($query);
        $html=new Smarty;
        $usuarios=array();
        $query="select * from usuarios";
        $res=$db->query($query);
        if($db->affected_rows>0)
        {
            while($fila=$res->fetch_array())
            {
                $usuarios[$fila["id"]]=array("id"=>$fila["id"], "usuario"=>$fila["usuario"]
                                  , "usuario"=>$fila["nombre"], "usuario"=>$fila["apellido"]);
            }
        }
        /*echo $_SESSION["admin"];*/
        $sesion=$_SESSION["admin"];
        //$comple=$_SESSION["completo"];
        /*echo $sesion;*/
        $cola="select * from usuarios where control='$sesion'";
        $control=array();
        $resultado=$db->query($cola);
        $valor=$resultado->fetch_array();
        $control[$valor["id"]]=array("id"=>$valor["id"], "usuario"=>$valor["usuario"], "tipo"=>$valor["tipo"]
                                , "nombre"=>$valor["nombre"], "apellido"=>$valor["apellido"]);
        
        if($valor['tipo']=="a" OR $valor['tipo']=="b")
        {
            $html->assign("valor",$control);
            $html->assign("usuarios",$usuarios);
            $html->display("index.html");
        }
        else
        {
            $html->assign("valor",$control);
            $html->assign("usuarios",$usuarios);
            $html->display("index2.html");
        }
    }
?>
