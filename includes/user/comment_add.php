<?php
    $database = connectToDB();

    $user = $_SESSION["user"]['user_id'];
    $userpage = $_POST["id"];
    $content = $_POST["content"];

    if ( empty($content) ){
        $_SESSION["error"] = "Comment must not be empty.";
        header("Location: /user/comment/add?id=$userpage");  
        exit;
    };

    $sql = "INSERT INTO userpage_comments (`userpage_id`, `commenter_id`, `content`) VALUES (:userpage, :commenter, :content)";
        
    $query = $database->prepare($sql);

    $query->execute(["userpage" => $userpage, "commenter" => $user, "content" => $content]);
        
    $_SESSION["success"] = "Comment added successfully.";
    header("Location: /userpage?id=$userpage");  
    exit;

?>