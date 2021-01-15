<?php

session_start();

if (session_id() == '' || !isset($_SESSION) || !isset($_SESSION["ID"])) {
    header('Location: ../html/login.html');
    exit;
}

try{
    $db = new PDO("mysql:dbname=bestecommerceever;host=localhost:3306", "root", "");

    $id= $_SESSION["ID"];


    $result= $db->query("SELECT *
                            FROM Products JOIN Orders ON (ID_Product = ID )
                            WHERE ID_User= $id;");

    //$result= $result->fetchAll();
    $rows = array();

    while($row = $result->fetch()){
        if($row["Img"] != null){
            $new_row["ID_Product"]= $row["ID_Product"];
            $new_row["Name"]= $row["Name"];
            $new_row["Description"]= $row["Description"];
            $new_row["Img"]= base64_encode($row["Img"]);
            $new_row["Qty"]= $row["Qty"];
            $new_row["Category"]= $row["Category"];
            $new_row["Price"]= $row["Price"];
            $new_row["Discount"]= $row["Discount"];
            
            $rows[]= $new_row;
        }else{
            $rows[]= $row;
            
        }
        
    }

    print json_encode($rows);

}catch(PDOException $ex){
    die('Could not connect: ' . $ex->getMessage());
}

?>