<?php
require_once 'HTTP/Request2.php';
                            $request = new HTTP_Request2();
                            $request->setUrl('https://apis.datos.gob.ar/georef/api/provincias');
                            $request->setMethod(HTTP_Request2::METHOD_GET);
                            $request->setConfig(array(
                                'follow_redirects' => TRUE
                            ));
                            $request->setHeader(array(
                               
                                'Accept' => 'application/vnd.gestion.online+json',
                                'X-Force-Content-Type' => 'application/json'
                            ));

                            try {
                                $response = $request->send();
                                if ($response->getStatus() == 200) 
                                {
                                    $muestra = $response->getbody();
                                    //echo $muestra.'<BR>';
                                    //$data = file_get_contents("data/products.json");
                                   // $products = json_decode($muestra, true);
                                   
                                    $total_caracteres = strlen($muestra);
                                    $primer_corchete = strpos($muestra, '[', 0);
                                    $segundo_corchete = strpos($muestra, ']');
                                    //echo 'El primer corchete es '. $primer_corchete.'<BR>';
                                    //echo 'El segundo corchete es '. $segundo_corchete.'<BR>';
                                    $muestra = substr($muestra,$primer_corchete,$segundo_corchete-($primer_corchete-1));
                                    $cursor = 0;
                                    //echo $muestra;
                                    //$products = json_decode($todos, true);  
                                    $products = json_decode($muestra, true);  
                                    //echo "Largo".strlen($muestra);                         
                                    $productis = sort($products);
                                    //echo '<select class="col-lg-8" name="provincia" id="proveedor" onchange="CargarProductos(this.value);"';
                                     echo '<option value="">Seleccionar</option>';
                                    foreach ($products as $product=>$nombre) {
                                        //echo '<pre>';
                                        //print_r($product);
                                       // print_r($nombre['nombre']);
                                        echo '<option value="'.$nombre['id'].'">'.$nombre['nombre'].'</option>';

                                        //echo '</pre>';
                                    }
?>
