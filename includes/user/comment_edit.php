<?php
    $database = connectToDB();

    $id = $_POST["id"];
    $userpage = $_POST["userpage"];
    $content = $_POST["content"];

    if ( empty($content) ){
        $_SESSION["error"] = "Comment must not be empty.";
        header("Location: /user/comment/edit?id=$id");  
        exit;
    };

    $sql = "UPDATE userpage_comments SET content = :content WHERE up_comment_id = :id";
        
    $query = $database->prepare($sql);

    $query->execute(["content" => $content, "id" => $id]);
        
    $_SESSION["success"] = "Comment edited successfully.";
    header("Location: /userpage?id=$userpage");  
    exit;

?>