<?php
include_once("Functions.php");
$mysqli = connect();
if(isset($_GET['cityId'])) {
    $cityId = $_GET['cityId'];
    $result = $mysqli->query("SELECT id,hotel, cost, stars, info FROM hotels WHERE cityid = $cityId");
    $hotels = [];
    while($row = $result->fetch_assoc()) {
        $hotels[] = $row;
    }
    echo json_encode($hotels);
}
?>