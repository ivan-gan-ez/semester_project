<?php
    $database = connectToDB();

    $number = $_POST["number"];
    $fact = $_POST["fact"];
    $image = $_FILES["image"];

    if ( empty($fact) ){
        $_SESSION["error"] = "Fact field required.";
        header("Location: /fact/add?number=$number");  
        exit;
    };

    if ( !empty($image['name']) ) {

    // tell PHP where upload folder is
    $target_folder = "uploads/";
    // add image to name to upload folder path
    $target_path = $target_folder.date("YmdHisv").basename($image['name']);
    // move file to uploads folder
    move_uploaded_file( $image["tmp_name"], $target_path );

    $sql = "INSERT INTO facts (`number`, `fact`, `image`) VALUES (:number, :fact, :image)";
        
    $query = $database->prepare($sql);
        
    $query->execute(["number" => $number, "fact" => $fact, "image" => "/".$target_path]);
        
    $_SESSION["success"] = "Fact added successfully.";
    header("Location: /page/edit?number=$number");  
    exit;

    } else {

    $sql = "INSERT INTO facts (`number`, `fact`) VALUES (:number, :fact)";
        
    $query = $database->prepare($sql);

    $query->execute(["number" => $number, "fact" => $fact]);
        
    $_SESSION["success"] = "Fact added successfully.";
    header("Location: /page/edit?number=$number");  
    exit;

};

?>