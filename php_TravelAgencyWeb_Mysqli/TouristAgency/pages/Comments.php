<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include_once("Functions.php");
$mysqli = connect();

// создаем таблицу комментариев
$ct_comments = "CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    hotel_id INT NOT NULL,
    comment TEXT NOT NULL,
    posted TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (hotel_id) REFERENCES hotels(id)
) DEFAULT CHARSET='utf8mb4';";

if (!$mysqli->query($ct_comments)) {
    printf("Error creating table: %s\n", $mysqli->error);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Comments Page</title>
<!--    <link rel="stylesheet" href="../css/styles.css">-->
</head>
<body>
<div >
    <?php

    // форма для добавления комментариев
    if (isset($_SESSION['user_id'])) {
        echo "<form id='commentForm' action='' method='post'>";
        echo "<textarea name='comment' required></textarea><br>";
        // список отелей для комбобокса
        $hotelsQuery = "SELECT id, hotel FROM hotels ORDER BY hotel";
        $hotelsResult = $mysqli->query($hotelsQuery);
        echo "<select name='hotel_id' required>";
        while ($hotel = $hotelsResult->fetch_assoc()) {
            echo "<option value='" . $hotel['id'] . "'>" .($hotel['hotel']) . "</option>";
        }
        echo "</select><br>";
        echo "<input type='submit' value='Post Comment'>";
        echo "</form>";
    }

// показываем все комментарии
echo "<h3>Comments</h3>";

    $sql = "SELECT c.comment, c.posted, u.login FROM comments c JOIN users u ON c.user_id = u.id ORDER BY c.posted DESC";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div >";
            echo "<p><strong>" . htmlspecialchars($row['login']) . "</strong> at " . $row['posted'] . "</p>";
            echo "<p>" . htmlspecialchars($row['comment']) . "</p>";
            echo "</div><hr>";
        }
    } else {
        echo "<p>No comments yet</p>";
    }

    // добавление комментария
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'], $_POST['hotel_id'], $_SESSION['user_id'])) {
        $comment = $mysqli->real_escape_string($_POST['comment']);
        $hotel_id = $_POST['hotel_id'];
        $user_id = $_SESSION['user_id'];

        // запрос на добавление комментария в БД
        $sql = "INSERT INTO comments (user_id, hotel_id, comment) VALUES ('$user_id', '$hotel_id', '$comment')";
        if ($mysqli->query($sql)) {
            echo "<p>Comment added successfully!</p>";
            // перенаправление
            // header("Location: pages/Comments.php");
            // header("Location: index.php");
            header("Location: index.php?page=2");
            exit();
        } else {
            echo "<p>Error: " . $mysqli->error . "</p>";
        }
    }

    ?>

</body>
</html>