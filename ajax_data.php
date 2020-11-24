<?php
include("connMysqlObj.php");
$seldb = @mysqli_select_db($db_link, "pydata");

$sql_query = "SELECT COUNT(*) FROM data2 ";
$result = mysqli_query($db_link, $sql_query);
while($row_result=mysqli_fetch_assoc($result)){
    $total_records = $row_result['COUNT(*)'];
}

$sql_query = "SELECT * FROM data2 ";
$sql_query_limit = $sql_query." LIMIT ".($total_records - 1).", ".$total_records;
$result = mysqli_query($db_link, $sql_query_limit);
while($row_result=mysqli_fetch_assoc($result)){
    echo json_encode(array("value" => $row_result['value'] , "time" => $row_result['time']));
}
$db_link->close();
