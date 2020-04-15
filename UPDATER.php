<?php
/*
Copyright 2020 por Arcane Protection
License: LICENSE.md
URL License: https://arcaneprotection.net/LICENSE_APINET/LICENSE.md
 */
require("APINET.php");
$version_nueva = file_get_contents(MIGUELURL."UPDATE_CONTROL/WEB/Version.php");
$version_nueva = json_decode($version_nueva);
$version_nueva = str_replace('.','',$version_nueva->version);
$version_actual = str_replace('.','',$APINET_VERSION);

$rauter_file = "Rauter_Updating.APINET";
$file_file = "File_Updating.APINET";

if(file_exists($rauter_file) or file_exists($file_file)){
header("location: UPDATING.php");
}
if($version_nueva > $version_actual){
    $rauter = file_get_contents(MIGUELURL."UPDATE_CONTROL/WEB/Rauter.php");
    $cantidad = strlen($rauter)-1;
    $rauter = substr($rauter,0,$cantidad);
    $rauter = explode(',',$rauter);
    // crea las carpetas

    $rauter = json_encode($rauter);
    $archivo = fopen("Rauter_Updating.APINET", "w+");
    fwrite($archivo,$rauter);
    $cerro = fclose($archivo);

    $rauter = file_get_contents(MIGUELURL."UPDATE_CONTROL/WEB/Updater_Data.php");

    $rauter = $rauter;
    $archivo = fopen("File_Updating.APINET", "w+");
    fwrite($archivo,$rauter);
    $cerro = fclose($archivo);


    header("location: UPDATING.php");
}else{
        if(APINET_LANG == "en"){
            echo "<body style=' background: #000;'><b style='color: #FFF;' >You already have the latest version.</b></body>";
        }else{
            echo "<body style=' background: #000;'><b style='color: #FFF;' >Ya tienes la última versión.</b></body>";
        }
}
 ?>
