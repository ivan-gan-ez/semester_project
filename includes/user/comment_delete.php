<?php

$database = connectToDB();

$id = $_POST["id"];
$userpage = $_POST["userpage"];

// Get data from database
// 2.333: recipe (sql command)
$sql = "DELETE FROM userpage_comments WHERE up_comment_id = :id";

// 2.666: prepare material (prepare sql query)
$query = $database->prepare($sql);

// 3: cook it (execute the sql query)
$query->execute(["id" => $id]);

// 4: redirect user
header("Location: /userpage?id=$userpage");  
exit;
?>
