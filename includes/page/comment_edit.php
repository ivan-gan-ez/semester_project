<?php
    $database = connectToDB();

    $id = $_POST["id"];
    $number = $_POST["number"];
    $content = $_POST["content"];

    if ( empty($content) ){
        $_SESSION["error"] = "Comment must not be empty.";
        header("Location: /comment/edit?id=$id");  
        exit;
    };

    $sql = "UPDATE page_comments SET content = :content WHERE comment_id = :id";
        
    $query = $database->prepare($sql);

    $query->execute(["content" => $content, "id" => $id]);
        
    $_SESSION["success"] = "Comment edited successfully.";
    header("Location: /page?number=$number");  
    exit;

?>