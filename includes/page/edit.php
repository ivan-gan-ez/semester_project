<?php
    $database = connectToDB();
    
    $id = $_POST["number"];
    $primefactorisation = $_POST["primefactorisation"];
    $factors = $_POST["factors"];
    
    $sql = "SELECT * FROM pages WHERE page_id = :number";

    $query = $database->prepare($sql);

    $query->execute(["number" => $id]);

    $number = $query->fetch();

    if($number) {

        $sql = "UPDATE pages SET prime_factorisation = :prime_factorisation, factors = :factors WHERE page_id = :id";
            
        $query = $database->prepare($sql);

        $query->execute(["prime_factorisation" => $primefactorisation, "factors" => $factors, "id" => $id]);
            
        $_SESSION["success"] = "Page updated successfully.";
        header("Location: /page?number=$id");  
        exit;

    } else {

        $sql = "INSERT INTO pages (`page_id`, `prime_factorisation`, `factors`) VALUES (:id, :pf, :factors)";
        
        $query = $database->prepare($sql);

        $query->execute(["pf" => $primefactorisation, "factors" => $factors, "id" => $id]);
            
        $_SESSION["success"] = "Page updated successfully.";
        header("Location: /page?number=$id");  
        exit;

    }

?>