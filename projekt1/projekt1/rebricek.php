<!doctype html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rebricek sportovcov</title>
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
    <!-- <a href="google.php">Goog+le</a> -->
    <a href="index.php">Naspäť</a>

    <a href="../zadanie1/2fa/index.php">Registrácia</a>
    </div>

<!-- <table>
    <tr>
        <th>Name</th>
         <th>Surname</th>
        <th>ID</th>
        <th>Year</th>
        <th>Type</th>
        <th>Discipline</th>
        <th>Placing</th>
        <th>Game Order</th>
    </tr> -->
    <table>
    <tr>
        
        <th><a href="#" onclick="sortTable(0)">Surname</a></th>
        <th><a href="#" onclick="sortTable(1)">Name</a></th>
        <th>game_ID</th>
        <th><a href="#" onclick="sortTable(3)">Discipline</th>
        <th>Počet zlatých medail</th>
        <th>Placing</th>
        <th>year</th>
        <th><a href="#" onclick="sortTable(7)">type</th>
        <th><a href="#" onclick="sortTable(8)">city</th>

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




$stmt = $db->prepare(
    "SELECT person.id, person.name, person.surname, placement.person_id, placement.discipline, placement.placing, placement.game_id 
FROM person 
JOIN placement 
ON person.id = placement.person_id");
$stmt->execute();

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



?>

<script>
function sortTable(columnIndex) {
  var table = document.querySelector('table');
  var rows = Array.from(table.querySelectorAll('tbody tr'));
  var isNumeric = columnIndex === 9;

  rows.sort(function(a, b) {
    var aData = a.cells[columnIndex].textContent.trim();
    var bData = b.cells[columnIndex].textContent.trim();
    
    if (aData === 'Surname' || aData === 'Name'|| aData ==='Discipline' ||  aData === 'city'  ) {
      return -1;
    } else if (bData === 'Surname' || bData === 'Name' || bData === 'Discipline' || bData === 'city' ) {
      return 1;
    }
    
    if (isNumeric) {
      return Number(aData) - Number(bData);
    } else {
      return aData.localeCompare(bData);
    }
  });

  if (table.getAttribute('data-sorted') === columnIndex.toString()) {
    rows.reverse();
    table.removeAttribute('data-sorted');
  } else {
    table.setAttribute('data-sorted', columnIndex.toString());
  }

  var tbody = table.querySelector('tbody');
  tbody.innerHTML = '';
  rows.forEach(function(row) {
    tbody.appendChild(row);
  });
}
</script>






