<?php

include_once("Functions.php");
$mysqli = connect();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select Tours</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <h2>Select Tours</h2>
    <hr>

    <!-- форма выбора страны -->
    <form id="formCountry" action="javascript:void(0);">
<!--выбор страны активирует функцию loadHotels(реализованная в tours.js, которая отправляет AJAX-запрос к getCities.php), передавая IDстраны-->
        <select id="countrySelect" name="countryid" onchange="loadCities(this.value);" class="col-sm-3 col-md-3 col-lg-3">
            <option value="0">Select country...</option>
            <?php
            //здесь список стран загружается без использования AJAX при первичной загрузке страницы
            $res = $mysqli->query("SELECT * FROM countries ORDER BY country");
            while ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
                echo '<option value="'.$row[0].'">'.$row[1].'</option>';
            }
            mysqli_free_result($res);
            ?>
        </select>
        <input style="border-radius: 7px ; padding: 3px " type="submit" value="Select Country" class="btn btn-xs btn-primary">
    </form>

    <!-- форма выбора города -->
    <form id="formCity" action="javascript:void(0);">
        <select id="citySelect" name="cityid" onchange="loadHotels(this.value);" class="col-sm-3 col-md-3 col-lg-3">
            <option value="0">Select city...</option>
        </select>
        <input type="submit" value="Select City" class="btn btn-xs btn-primary">
    </form>

    <!-- список отелей -->
    <ul id="hotelList"></ul>

    <script src="js/tours.js"></script>
    <script src="js/jquery-3.1.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
