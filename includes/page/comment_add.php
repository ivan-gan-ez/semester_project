<?php
    $database = connectToDB();

    $user = $_SESSION["user"]['user_id'];
    $number = $_POST["number"];
    $content = $_POST["content"];

    if ( empty($content) ){
        $_SESSION["error"] = "Comment must not be empty.";
        header("Location: /comment/add?number=$number");  
        exit;
    };

    $sql = "INSERT INTO page_comments (`user_id`, `page_id`, `content`) VALUES (:user, :page, :content)";
        
    $query = $database->prepare($sql);

    $query->execute(["user" => $user, "page" => $number, "content" => $content]);
        
    $_SESSION["success"] = "Comment added successfully.";
    header("Location: /page?number=$number");  
    exit;

?>