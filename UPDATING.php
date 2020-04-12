<?php
require("APINET.php");
$rauter_file = "Rauter_Updating.APINET";
$file_file = "File_Updating.APINET";
if(file_exists($rauter_file)){

    $data = "";
    $archivo = fopen($rauter_file, "r");
    while(!feof($archivo)){
        $leer = fgets($archivo);
        $data .= $leer;
    }
    foreach (json_decode($data) as $value) {
        $value = trim($value," ");
        if(!is_dir("../APINET".$value)){
            mkdir("../APINET".$value, 0777, true);
        }
    }
    unlink($rauter_file);
}

if(file_exists($file_file)){
    $data = "";
    $archivo = fopen($file_file, "r");
    while(!feof($archivo)){
        $leer = fgets($archivo);
        $data .= $leer;
    }
    $data = json_decode($data);
    $data[0][0] = "/APINET.php";
    foreach ($data as $value) {
        if(substr($value[0],1) != "li.php"){
            $datos = base64_decode($value[1]);
            if(substr($value[0],1) == "APINET.php"){

                $datos = str_replace('asdasdjaklasd34', APINET_LI, $datos);
                $datos = str_replace('email@pass.pass', APINET_E, $datos);

            }
        $archivo = fopen("../APINET/".substr($value[0],1), "w+");
        $contar = strlen($datos);
        if($contar > 0){
            fwrite($archivo,$datos);
        }
        $cerro = fclose($archivo);
        }
    }
    unlink($file_file);
}


 ?>
