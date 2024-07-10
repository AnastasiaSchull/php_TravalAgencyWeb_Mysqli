<?php
include_once("Functions.php");
$mysqli = connect();
//сервер выполняет запрос к бд
if(isset($_GET['countryId'])) {
    $countryId = $_GET['countryId'];
    $result = $mysqli->query("SELECT * FROM cities WHERE countryid = $countryId ORDER BY city");
    $cities = [];
    //формирование массива
    while($row = $result->fetch_assoc()) {
        $cities[] = $row;
    }
    //конвертация в JSON,json_encode()-это текстовое представление данных в формате JSON
    echo json_encode($cities);
}
?>

