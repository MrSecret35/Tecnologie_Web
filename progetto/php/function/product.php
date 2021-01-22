<?php

try{
    include("connectionDB.php");
    $db =connect();
    
    $rows = array();
    $result= $db->query("SELECT *
                            FROM Products
                            WHERE Qty >=1 ");
    //$result= $result->fetchAll(PDO::FETCH_ASSOC);

    //print json_encode($result->fetchAll(PDO::FETCH_ASSOC));
    while($row = $result->fetch()){
        
        if($row["Img"] != null){
            $new_row["ID"]= $row["ID"];
            $new_row["Name"]= $row["Name"];
            $new_row["Description"]= $row["Description"];
            $new_row["Img"]= base64_encode($row["Img"]);
            $new_row["Qty"]= $row["Qty"];
            $new_row["Category"]= $row["Category"];
            $new_row["Price"]= $row["Price"];
            $new_row["Discount"]= $row["Discount"];
            $new_row["ID_Seller"]= $row["ID_Seller"];
            
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