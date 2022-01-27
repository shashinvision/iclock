<?php
require_once './env.php';
// require_once "./ZKTeco_Attendance_Access_Using_PHP/zklibrary.php";
require_once('zklib/ZKLib.php');

/*
 * @author: Felipe Mancilla
 * Date: 2022/01/25
 * @description: se recibe data por get con la ip y serial del dispositivo, este archivo debe ser ejecutado por un CronJob o tarea programada
 * se debe considerar un cronjob por cada reloj y este debe ser ejecutado con un maximo de 1 segundo (idealmente 0.5 seg).
 * @exec : ejemplo de ejecución  manual: http://localhost/iclock/cdata?ip=10.6.17.216
 * @exec : ejemplo de ejecución cron: 1 * * * * /usr/bin/curl --silent "http://localhost/iclock/cdata.php?ip=10.6.17.116" &> /dev/null

  */

ini_set('display_errors', 'On');
error_reporting(E_ALL);

if (
    isset($_GET['ip'])
) {

    $ip = $_GET['ip'];

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
    getAsistencia($ip);
    $time_end = microtime(true);

    //dividing with 60 will give the execution time in minutes otherwise seconds
    echo "<hr>";
    echo "Ejecución en tiempo real tomó: ";
    echo $execution_time = ($time_end - $time_start) / 60;
    echo " segundos.";
}

/**
 * 
 * @param string $ip 
 * @return void 
 */

function getAsistencia($ip = "")
{
    $asistencia = array();

    $zk = new ZKLib($ip);
    $ret = $zk->connect();

    if ($ret) {
        $zk->disableDevice();
        $zk->setTime(date('Y-m-d H:i:s')); // Synchronize time

        $serialSub = substr($zk->serialNumber(), 14);
        $serial = substr($serialSub, 0, -1);
        $attendance = $zk->getAttendance();
        // echo "<pre>";
        // var_dump($serial);
        // echo "<hr>";
        // var_dump($attendance);
        // echo "</pre>";
        if (count($attendance) > 0) {
            $attendance = array_reverse($attendance, true);
            sleep(1);


            foreach ($attendance as $attItem) {
                $asistencia['uid'] = $attItem['uid'];
                $asistencia['id'] = $attItem['id'];
                $asistencia['name'] = isset($users[$attItem['id']]) ? $users[$attItem['id']]['name'] : $attItem['id'];
                $asistencia['state'] = ZK\Util::getAttState($attItem['state']);
                $asistencia['date'] = date("d-m-Y", strtotime($attItem['timestamp']));
                $asistencia['time'] = date("H:i:s", strtotime($attItem['timestamp']));
                $asistencia['serial'] = $serial;
                $asistencia['type'] = ZK\Util::getAttType($attItem['type']);
                $asistencia['ip'] = $ip;
            }

            setDataAsistenciaBd($asistencia);
            $zk->clearAttendance(); // Remove attendance log only if not empty

        }
        $zk->enableDevice();
    }

    $zk->disconnect();
}

/**
 * Se encarga de ingresar la data en el modelo de la BBDD creado
 * @param array $asistencia 
 * @return bool 
 */

function setDataAsistenciaBd($asistencia)
{

    echo "<pre>";
    echo "<hr>";
    echo "asistencia";
    var_dump($asistencia);
    echo "<hr>";
    echo "</hr>";


    $uid = $asistencia['uid'];
    $id = $asistencia['id'];
    $name = $asistencia['name'];
    $state = $asistencia['state'];
    $date = $asistencia['date'];
    $time = $asistencia['time'];
    $serial = $asistencia['serial'];
    $type = $asistencia['type'];
    $ip = $asistencia['ip'];

    $conn = new mysqli(SERVER, USER, PASS, DB);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $query = "INSERT INTO marcaciones (id, uid, name, state, date, time, serial, type, ip, created_at) VALUES('$id', '$uid', $name, '$state', '$date', '$time', '$serial', '$type', '$ip', NOW());";

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
