<?php
    $database = connectToDB();

    $name = $_POST["name"];
    $id = $_POST["id"];
    $fav_num = $_POST["favnumber"];
    $image = $_FILES["image"];
    $desc = $_POST["desc"];
    $role = $_POST["role"];

    if ( empty($name) ){
        $_SESSION["error"] = "Name field required.";
        header("Location: /user/edit?id=$id");  
        exit;
    };

    if ( !empty($image['name']) ) {

    // tell PHP where upload folder is
    $target_folder = "uploads/";
    // add image to name to upload folder path
    $target_path = $target_folder.date("YmdHisv").basename($image['name']);
    // move file to uploads folder
    move_uploaded_file( $image["tmp_name"], $target_path );

    $sql = "UPDATE users SET name = :name, fav_num = :fav_num, profile_picture = :image, `desc` = :desc, role = :role WHERE user_id = :id";
        
    $query = $database->prepare($sql);
        
    $query->execute(["name" => $name, "fav_num" => $fav_num, "desc" => $desc, "role" => $role, "image" => "/".$target_path, "id" => $id]);
        
    $_SESSION["success"] = "Information updated successfully.";
    header("Location: /user/manage");  
    exit;

    } else {

    $sql = "UPDATE users SET name = :name, fav_num = :fav_num, `desc` = :desc, role = :role WHERE user_id = :id";
        
    $query = $database->prepare($sql);

    $query->execute(["name" => $name, "fav_num" => $fav_num, "desc" => $desc, "role" => $role, "id" => $id]);
        
    $_SESSION["success"] = "Information updated successfully.";
    header("Location: /user/manage");  
    exit;

};
?>