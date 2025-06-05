<?php
    $database = connectToDB();

    $number = $_POST["number"];

    if ( empty($number) ){
        $_SESSION["error"] = "Number must not be empty.";
        header("Location: /");  
        exit;
    };

    if ( !is_numeric($number) or str_contains($number, "e") ){
        $_SESSION["error"] = "Not an integer.";
        header("Location: /");  
        exit;
    };

    //if number doesn't exist in pages database then we add it because we don't want foreign keys to implode
    $sql = "SELECT * FROM pages WHERE page_id = :number";

    $query = $database->prepare($sql);

    $query->execute(["number" => $number]);

    $dnumber = $query->fetch();

    if(!$dnumber) {

        //set number variable to integer because it's a string for some reason
        $number = $number + 0;

        $sql = "INSERT INTO pages (`page_id`, `prime_factorisation`, `factors`) VALUES (:id, :pf, :factors)";
        
        $query = $database->prepare($sql);

        $query->execute(["pf" => "", "factors" => "", "id" => $number]);

    }

    //the actual featured stuff
    $sql = "INSERT INTO featured (`number`) VALUES (:number)";
        
    $query = $database->prepare($sql);

    $query->execute(["number" => $number]);
        
    $_SESSION["success"] = "Number added successfully.";
    header("Location: /");  
    exit;

?>