<?php
    $database = connectToDB();

    // 3: get data from login page
    $email = $_POST["email"];
    $password = $_POST["password"];

    // 4: check for error
    if ( empty($email) || empty($password) ) {
        $_SESSION["error"] = 'All fields required.';
        header("Location: /login");
        exit;
    };

    $user = getUserByEmail($email);

    if ( !$user ) {
        $_SESSION["error"] = 'Email not found. Please sign up.';
        header("Location: /login");
        exit;
    };

    if ( !password_verify( $password, $user["password"]) ) {
        $_SESSION["error"] = 'Email or password incorrect.';
        header("Location: /login");
        exit;
    };

    // 8: store user data in session
    $_SESSION["user"] = $user;

    // 9: redirect user back to main page
    unset($_SESSION["error"]);
    $_SESSION["success"] = "Welcome back, ".$user['name']."!";
    header("Location: /");
    exit;
?>