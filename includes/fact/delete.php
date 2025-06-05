<?php

$database = connectToDB();

$id = $_POST["fact_id"];
$number = $_POST["number"];

// Get data from database
// 2.333: recipe (sql command)
$sql = "DELETE FROM facts WHERE fact_id = :id";

// 2.666: prepare material (prepare sql query)
$query = $database->prepare($sql);

// 3: cook it (execute the sql query)
$query->execute(["id" => $id]);

// 4: redirect user
header("Location: /page/edit?number=$number");  
exit;
?>
