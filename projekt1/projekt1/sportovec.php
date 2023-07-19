<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail sportovca</title>
    <link rel="stylesheet" type="text/css" href="../zadanie1/tabulky.css">

   
</head>
<style>
    .navbar {
  background-color: #f2f2f2;
  padding: 10px;
  text-align: center;
}

.navbar a {
  display: inline-block;
  color: #666;
  padding: 10px 20px;
  text-decoration: none;
}

.navbar a:hover {
  background-color: #ddd;
  color: #000;
}
</style>
<div class="navbar">
    <!-- <a href="admin.php">Admin</a> -->
    <!-- <a href="google.php">Google</a> -->
    <a href="rebricek.php">Naspäť</a>

    <a href="../zadanie1/2fa/index.php">Registrácia</a>
    </div>
<table>
    <tr>
        
        <th>Surname</a></th>
        <th>Name</a></th>
        <th>game_ID</th>
        <th>Discipline</th>
        <th>Počet zlatých medail</th>
        <th>Placing</th>
        <th>year</th>
        <th>type</th>
        <th>city</th>

    </tr>
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//pripojenie k databaze
require_once('config.php');
try{

$db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
  exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $stmt = $db->prepare("
        SELECT person.id, person.name, person.surname, placement.person_id, placement.discipline, placement.placing, placement.game_id 
        FROM person 
        JOIN placement 
        ON person.id = placement.person_id 
        WHERE person.id = :id"
    );
    $stmt->execute(array(':id' => $id));

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        
        echo "<tr>";

        echo "<td><a href='sportovec.php?id=" . $row['person_id'] . "&game_id=" . $row['game_id'] . "'>" . $row['surname'] . "</a></td>";
        echo "<td><a href='sportovec.php?id=" . $row['person_id']." '>".$row['name'] . "</a></td>";
        echo "<td>".$row['game_id']."</td>";
        echo "<td>".$row['discipline']."</td>";

        $countStmt = $db->prepare("SELECT SUM(placing = 1) AS count FROM placement WHERE person_id = :person_id");
        $countStmt->execute(array(':person_id' => $row['person_id']));
        $countRow = $countStmt->fetch(PDO::FETCH_ASSOC);
        
        echo "<td>".$countRow['count']."</td>";

        echo "<td>".$row['placing']."</td>";
        
        $gameStmt = $db->prepare("SELECT year, type, city FROM game WHERE game_order=:game_order");
        $gameStmt->execute(array(':game_order' => $row['game_id']));
        $gameRow = $gameStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($gameRow) {
            echo "<td>".$gameRow['year']."</td>";
            echo "<td>".$gameRow['type']."</td>";
            echo "<td>".$gameRow['city']."</td>";
        }
        
        echo "</tr>";
    }
}

?>
