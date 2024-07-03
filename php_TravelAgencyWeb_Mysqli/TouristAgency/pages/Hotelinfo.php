<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Hotel Info</title>
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<link rel="stylesheet" href="../css/info.css">
	</head>
<body>
<?php
include_once ("functions.php");
$mysqli = connect();


if(isset($_GET['hotel']))
{
	$hotel=$_GET['hotel'];
//	$mysqli = connect();
	$sel='select * from hotels where id='.$hotel;
	$res=$mysqli->query($sel);
	$row=mysqli_fetch_array($res, MYSQLI_NUM);
	$hname=$row[1];
	$hstars=$row[4];
	$hcost=$row[5];
	$hinfo=$row[6];
	mysqli_free_result($res);
	echo '<h2 class="text-uppercase text-center">'.$hname.'</h2>';
	echo '<div class="row"><div class="col-md-6 text-center">';
    //$mysqli = connect();
	$sel='select imagepath from images where hotelid='.$hotel;
	$res=$mysqli->query($sel);
	echo '<span class="label label-info">Watch our pictures</span>';
	echo'<ul id="gallery">';
	$i=0;
	while($row=mysqli_fetch_array($res, MYSQLI_NUM))
	{
		echo '<li><img src="../'.$row[0].'"></li>';
	}
	mysqli_free_result($res);
	echo '</ul>';
	for ($i=0; $i<$hstars; $i++)
	{
		echo '<img src="../images/star.png" alt="star">';
	}
	echo '<h2 class="text-center">Cost&nbsp;<span class="label label-info">'
	.$hcost.' $</span>';
	echo '<a href="#" class="btn btn-success">Book This Hotel</a></h2>';
	echo '</div><div class="col-md-6"><p class="well">'.$hinfo.'</p></div>';
	echo '</div></main>';

    // запрос для отображения комментариев
    $commentQuery = "SELECT u.login, c.comment, c.posted 
                 FROM comments c 
                 JOIN users u ON c.user_id = u.id 
                 WHERE c.hotel_id = $hotel 
                 ORDER BY c.posted DESC";
    $comments = $mysqli->query($commentQuery);
    echo "<div style='color: #01707a; margin:30px '   ><h3>Comments:</h3>";
    if ($comments->num_rows > 0) {
        while ($comment = $comments->fetch_assoc()) {
            echo "<div class='comment'>";
            echo "<p><strong>" . htmlspecialchars($comment['login']) . "</strong> at " . $comment['posted'] . "</p>";
            echo "<p>" . htmlspecialchars($comment['comment']) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No comments yet.</p>";
    }
    echo '</div>';

}
 ?>

<script src="../js/jquery-3.1.0.min.js"></script>
<script src="../js/gallery.js"></script>
<script src="../js/info2.js"></script>
</body>
</html>