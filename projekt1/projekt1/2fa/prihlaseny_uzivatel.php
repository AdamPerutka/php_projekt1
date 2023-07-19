<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../config.php');

session_start();

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("Location: login.php");
    exit;
}

try {
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "SELECT * FROM person";
    $stmt = $db->query($query); 
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
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
table {
    border-collapse: collapse;
    width: 100%;
    max-width: 800px;
    margin: 0 auto;
    border: 2px solid black;
}

th, td {
    text-align: left;
    padding: 8px;
    border: 1px solid black;
}

th {
    background-color: #f2f2f2;
}
a, a:hover {
color: inherit;
text-decoration: none;
}

tr.clickable {
cursor: pointer;
}
.dropdown {
    position: relative;
    display: inline-block;
  }

  .dropdown-content {
    display: none;
    position: absolute;
    z-index: 1;
  }

  .dropdown:hover .dropdown-content {
    display: block;
  }



</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
        <link rel="stylesheet" type="text/css" href="../style.css">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</head>
<body>
<h1>Zadanie 1</h1>
<h3>Vitaj <?php echo $_SESSION['fullname']; ?></h3>
    <p><strong>Si prihlaseny pod emailom:</strong> <?php echo $_SESSION['email']; ?></p>
    <p><strong>Tvoj identifikator (login) je:</strong> <?php echo $_SESSION['login']; ?></p>
    <p><strong>Datum registracie/vytvonia konta:</strong> <?php echo $_SESSION['created_at'] ?></p>

    <a href="logout.php">Odhlasenie</a></p><br>
    <a href="index.php">Spat na hlavnu stranku</a></p>


    <div class="navbar">
    <!-- <a href="google.php">Google</a> -->
    <a href="rebricek.php">Rebricek</a>
    <!-- <a href="edit.html">Pridanie športovca</a> -->

    <div class="dropdown">
  <a>Admin Editing</a>
  <div class="dropdown-content">
    <a href="admin.php">Zmena športovca</a>
    <a href="edit.html">Pridanie športovca</a>
    <a href="odstraneniesportovca.php">Odstránenie športovca</a>
  </div>
</div>



    <!-- <a href="../zadanie1/2fa/index.php">Registrácia</a> -->
    </div>

    <div class="container-md">
    <table>
        
            <tr><th>Meno</hd><th>Priezvisko</th><th>Narodenie</th></tr>
       
        <?php //var_dump($results) 
        foreach($results as $result){
            $date = new DateTimeImmutable($result["birth_day"]);
        echo "<tr><td>" . $result["name"] . "</td><td>" . $result["surname"] . "</td><td>" . $date->format("d.m.Y") . "</td></tr>";
        }
        ?> 
        </tbody>
    </table>
    </div>
</body>
</html>