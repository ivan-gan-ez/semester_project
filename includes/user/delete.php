<?php

$database = connectToDB();

$user_id = $_POST["user_id"];

// 2.333: recipe (sql command)
$sql = "DELETE FROM userpage_comments WHERE commenter_id = :id";

// 2.666: prepare material (prepare sql query)
$query = $database->prepare($sql);

// 3: cook it (execute the sql query)
$query->execute(["id" => $user_id]);

// 2.333: recipe (sql command)
$sql = "DELETE FROM page_comments WHERE user_id = :id";

// 2.666: prepare material (prepare sql query)
$query = $database->prepare($sql);

// 3: cook it (execute the sql query)
$query->execute(["id" => $user_id]);

// 2.333: recipe (sql command)
$sql = "DELETE FROM users WHERE user_id = :id";

// 2.666: prepare material (prepare sql query)
$query = $database->prepare($sql);

// 3: cook it (execute the sql query)
$query->execute(["id" => $user_id]);

// 4: redirect user
header("Location: /user/manage");  
exit;
?>
