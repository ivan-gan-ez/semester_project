<?php

$database = connectToDB();

$number = $_POST["number"];

// Get data from database
// 2.333: recipe (sql command)
$sql = "DELETE FROM featured WHERE number = :number";

// 2.666: prepare material (prepare sql query)
$query = $database->prepare($sql);

// 3: cook it (execute the sql query)
$query->execute(["number" => $number]);

// 4: redirect user
header("Location: /");  
exit;
?>
