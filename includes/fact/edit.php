<?php
    $database = connectToDB();

    $number = $_POST["number"];
    $id = $_POST["id"];
    $fact = $_POST["fact"];
    $image = $_FILES["image"];

    if ( empty($fact) ){
        $_SESSION["error"] = "Fact field required.";
        header("Location: /fact/edit?fact=$id");  
        exit;
    };

    if ( !empty($image['name']) ) {

    // tell PHP where upload folder is
    $target_folder = "uploads/";
    // add image to name to upload folder path
    $target_path = $target_folder.date("YmdHisv").basename($image['name']);
    // move file to uploads folder
    move_uploaded_file( $image["tmp_name"], $target_path );

    $sql = "UPDATE facts SET fact = :fact, image = :image WHERE fact_id = :id";
        
    $query = $database->prepare($sql);
        
    $query->execute(["fact" => $fact, "image" => "/".$target_path, "id" => $id]);
        
    $_SESSION["success"] = "Fact updated successfully.";
    header("Location: /page/edit?number=$number");  
    exit;

    } else {

    $sql = "UPDATE facts SET fact = :fact WHERE fact_id = :id";
        
    $query = $database->prepare($sql);

    $query->execute(["fact" => $fact, "id" => $id]);
        
    $_SESSION["success"] = "Fact updated successfully.";
    header("Location: /page/edit?number=$number");  
    exit;

};

?>