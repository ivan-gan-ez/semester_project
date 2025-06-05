<?php

$database = connectToDB();

$id = $_POST["id"];
$number = $_POST["number"];

// Get data from database
// 2.333: recipe (sql command)
$sql = "DELETE FROM page_comments WHERE comment_id = :id";

// 2.666: prepare material (prepare sql query)
$query = $database->prepare($sql);

// 3: cook it (execute the sql query)
$query->execute(["id" => $id]);

// 4: redirect user
header("Location: /page?number=$number");  
exit;
?>
