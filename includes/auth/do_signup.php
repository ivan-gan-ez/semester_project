<?php
    $database = connectToDB();

    // 3: get data from form
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    $user = getUserByEmail($email);

    // 5: check for error
    if ( $user ) {
        $_SESSION["error"] = "The email provided already exists in our system. Please log in.";
        header("Location: /signup");  
        exit;
    };

    if ( empty($name) || empty($email) || empty($password) || empty($confirm_password) ) {
        $_SESSION["error"] = 'All fields required.';
        header("Location: /signup");  
        exit;
    };

    if ( $password !== $confirm_password ) {
        $_SESSION["error"] = 'Your passwords do not match.';
        header("Location: /signup");  
        exit;
    };

    // 5.333: recipe (sql command)
    $sql = "INSERT INTO users (`name`, `email`, `password`) VALUES (:name, :email, :password)";
    
    // 5.666: prepare material (prepare sql query)
    $query = $database->prepare($sql);
     
    // 6: cook it (execute the sql query)
    $query->execute(["name" => $name, "email" => $email, "password" => password_hash($password, PASSWORD_DEFAULT)]);
             
    // 7: set success message
    $_SESSION["success"] = "Account created successfully. Please log in.";

    // 8: redirect user
    header("Location: /login");  
    exit;

?>