<?php

$database = connectToDB();

$id = $_POST["id"];
$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];

if ( empty($password) || empty($confirm_password) ) {
    $_SESSION["error"] = 'All fields required.';
} else if ( $password !== $confirm_password ){
    $_SESSION["error"] = 'Your passwords do not match.';
} else {

     // 5.333: recipe (sql command)
     $sql = "UPDATE users SET password = :password WHERE user_id = :id";

     // 5.666: prepare material (prepare sql query)
     $query = $database->prepare($sql);

     // 6: cook it (execute the sql query)
     $query->execute([ "password" => password_hash($password, PASSWORD_DEFAULT), "id" => $id ]);
     
     // 7: set success message
     $_SESSION["success"] = "Password updated successfully.";

     // 8: redirect user
    header("Location: /users/manage");  
    exit;
};
header("Location: /users/changepwd?id=$id");  
exit;

?>