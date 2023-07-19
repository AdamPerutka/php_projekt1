<!DOCTYPE html>
  <html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>

      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
  </head>
  <div class="navbar">
    <a href="admin.php">Admin</a>
    <!-- <a href="google.php">Goog+le</a> -->
    <a href="index.php">Naspäť</a>

    <a href="../zadanie1/2fa/index.php">Registrácia</a>
    </div>
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
}</style>
<link rel="stylesheet" type="text/css" href="../zadanie1/tabulky.css">

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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $ids = $_POST['ids'];

  $stmt = $pdo->prepare("DELETE FROM person WHERE id=:id");

  foreach ($ids as $id) {
    $stmt->bindParam(':id', $id);
    if ($stmt->execute()) {
      echo "Person with ID $id was successfully deleted.<br>";
    } else {
      echo "Error deleting person with ID $id: " . $stmt->errorInfo()[2] . "<br>";
    }
  }

  $stmt->closeCursor();
}

$sql = "SELECT id, name, surname FROM person";
$stmt = $pdo->query($sql);

if ($stmt->rowCount() > 0) {
  echo "<form method='post' action='" . $_SERVER['PHP_SELF'] . "'>";
  echo "<table><tr><th>ID</th><th>Name</th><th>Surname</th><th>Remove</th></tr>";
  while ($row = $stmt->fetch()) {
    echo "<tr><td>" . $row['id'] . "</td><td>" . $row['name'] . "</td><td>" . $row['surname'] . "</td><td><input type='checkbox' name='ids[]' value='" . $row['id'] . "'></td></tr>";
  }
  echo "</table>";
  echo "<input type='submit' value='Remove Selected'>";
  echo "</form>";
} else {
  echo "No people found in the database.";
}

$pdo = null;
?>
