<?php
require_once './env.php';
require_once "./ZKTeco_Attendance_Access_Using_PHP/zklibrary.php";


/*
 * @author: Felipe Mancilla
 * Date: 2022/01/25
 * @description: se recibe data por get con la ip y serial del dispositivo, este archivo debe ser ejecutado por un CronJob o tarea programada
 * se debe considerar un cronjob por cada reloj y este debe ser ejecutado con un maximo de 1 segundo (idealmente 0.5 seg).
 * @exec : ejemplo de ejecución  manual: http://localhost/iclock/cdata?SN=CEUY191060144&IP=10.6.17.216
 * @exec : ejemplo de ejecución cron: 1 * * * * /usr/bin/curl --silent "http://localhost/iclock/cdata.php?SN=CEUY191060144&IP=10.6.17.116" &>/dev/null

  */

ini_set('display_errors', 'On');
error_reporting(E_ALL);

if (
    isset($_GET['SN']) && isset($_GET['IP'])
) {

    $serial = $_GET['SN'];
    $ip = $_GET['IP'];

    // $respuesta = <<<EOT
    //     GET OPTION FROM:$serial
    //     Stamp=9999
    //     OpStamp=9999
    //     PhotoStamp=0
    //     ErrorDelay=60
    //     Delay=60
    //     TransTimes=00:00;14:05
    //     TransInterval=1
    //     TransFlag=TransData AttLog	OpLog	AttPhoto	EnrollFP	EnrollUser	ChgUser	ChgFP	UserPic	FACE
    //     Realtime=3
    //     Encrypt=0
    //     TimeZoneclock=-3
    //     TimeZone=-3
    //     OPERLOGStamp=9999
    //     EOT;

    // echo "<pre>$respuesta</pre>";

    //place this before any script you want to calculate time
    $time_start = microtime(true);
    getAsistencia($serial, $ip);
    $time_end = microtime(true);

    //dividing with 60 will give the execution time in minutes otherwise seconds
    echo "<hr>";
    echo "Ejecución en tiempo real tomó: ";
    echo $execution_time = ($time_end - $time_start) / 60;
    echo " segundos.";
}

/**
 * 
 * @param string $serial 
 * @param string $ip 
 * @return void 
 */

function getAsistencia($serial = '', $ip = "", $type_conn = 'UDP')
{

    if (isset($_GET['TYPE_CONN'])) {
        $type_conn = $_GET['TYPE_CONN'];
    }


    $zk = new ZKLibrary($ip, 4370, $type_conn);
    $zk->connect();
    $zk->disableDevice();
    $arregloData = $zk->getAttendance();

    echo "<pre>";
    var_dump($zk->recv());
    echo "</pre>";
    echo "<hr>";
    echo "<pre>";
    var_dump($arregloData);
    echo "</pre>";

    if (!empty($arregloData)) {

        $arregloData[0][0] = $serial;
        $arregloData[0][2] = $ip;

        if (setDataAsistenciaBd($arregloData[0])) {
            echo "Registro de marcación actualizado";
        } else {
            echo "No hay registros";
        }
    } else {
        echo "no se registran entradas";
    }
    $zk->clearAttendance();
    $zk->enableDevice();
    // $zk->testVoice();
    $zk->disconnect();
}

/**
 * Se encarga de ingresar la data en el modelo de la BBDD creado
 * @param array $arregloData 
 * @return bool 
 */

function setDataAsistenciaBd($arregloData)
{

    $serial = $arregloData[0];
    $id_rut_usuario = $arregloData[1];
    $ip = $arregloData[2];
    $tipo_marca = $arregloData[4]; // en el biometrico de test arroja 0 en entrada y 4 en salida, 201 es marca erronea registrada.
    // $dateTime = $arregloData[3]; // se prefirió usar NOW() directamente desde la BBDD, ya que el cronjob actualizará cada 1 seg. o 0.5 seg.

    $conn = new mysqli(SERVER, USER, PASS, DB);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $query = "INSERT INTO marcacion_reloj (serial_reloj, ip_reloj, id_rut_usuario, date_added, tipo_marca, estado) VALUES('$serial', '$ip', $id_rut_usuario, NOW(), $tipo_marca,  1);";

    if ($conn->query($query)) {
        $conn->close();
        return true;
    }
    return false;
}


/*
 En su momento se creo para identificar la variable table que se envia por el pseudo broadcast desde el dispositivo biometrico, 
 se conserva ya que puede ser de utilidad en el futuro
if (isset($_GET['table'])) {
    if ($_GET['table'] == 'FPRINT') {
        // $myfile = fopen("record_print_log.txt", "a+") or die("Unable to open file!");
        $myfile = fopen("record_print_log.txt", "a+") or die("Unable to open file!");

        $txt = "\n\r--------------REQUEST---------\n\r";
        $txt .= json_encode($_REQUEST);
        $txt .= "\n\r--------------FILE---------\n\r";
        $txt .= json_encode($_FILES);
        $txt .= "\n\r--------------POST---------\n\r";
        $txt .= json_encode($_POST);
        $txt .= "\n\r--------------GET--------_-\n\r";
        $txt .= json_encode($_GET);

        fwrite($myfile, $txt);
        fclose($myfile);
    }
}
 */
