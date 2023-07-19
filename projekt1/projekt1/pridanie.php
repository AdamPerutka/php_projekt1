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
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('config.php');


try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


} catch (PDOException $e) {
    echo $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $surname = $_POST["surname"];
  $birth_day = $_POST["birth_day"];
  $birth_place = $_POST["birth_place"];
  $birth_country = $_POST["birth_country"];

  $stmt = $pdo->prepare("INSERT INTO person (name, surname, birth_day, birth_place, birth_country) VALUES (:name, :surname, :birth_day, :birth_place, :birth_country)");

  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':surname', $surname);
  $stmt->bindParam(':birth_day', $birth_day);
  $stmt->bindParam(':birth_place', $birth_place);
  $stmt->bindParam(':birth_country', $birth_country);

  $stmt->execute();

  echo "Person added successfully!";
}
?>
