<?php
require 'vendor/autoload.php';
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

include("connMysqlObj.php");
$seldb = @mysqli_select_db($db_link, "pydata");
$pos = strrpos( $_GET["start"], " ");
if ($pos === true) {
    $starttime = $_GET["start"];
    $endtime = $_GET["end"];
}else{
    $starttime = $_GET["start"];
    $endtime = $_GET["end"];
}

$log = new Logger('name');
$log->pushHandler(new StreamHandler('m.log', Logger::INFO));
$log->addInfo(" Serrch  ".$starttime." to ".$endtime." ");

$sql_query_limit ="SELECT * FROM data2 WHERE time >= '".$starttime."' AND time <= '".$endtime."'";
$result = mysqli_query($db_link, $sql_query_limit);
$total_records = mysqli_num_rows($result);
$code=array();
if( $total_records > 300 ){
$skip = $total_records / 300;
$i = 0;
    while($row_result=mysqli_fetch_assoc($result)){
        $i ++;
        if( ($i%$skip) == 0 ){
            $i = 0;
            $row_array = array("value" => $row_result['value'] , "time" => $row_result['time']);
            array_push($code , $row_array );
        }
    }
}else{
    while($row_result=mysqli_fetch_assoc($result)){
        $row_array = array("value" => $row_result['value'] , "time" => $row_result['time']);
        array_push($code , $row_array );
    }
}
echo json_encode($code);

$db_link->close();