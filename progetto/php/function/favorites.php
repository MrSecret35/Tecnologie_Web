<?php
/*
    @autor: Giorgio Mecca
    Matricola : 880847
*/
/*
    funzione php per restituire tutti i prodotti presenti nella lista preferiti dell'utente della sessione
    in modalità JSON
*/

session_start();

if (session_id() == '' || !isset($_SESSION) || !isset($_SESSION["ID"])) {
    header('Location: ../../html/login.html');
    exit;
}

try{
    include("connectionDB.php");
    $db =connect();

    $id= $_SESSION["ID"];


    $result= $db->query("SELECT ID_Product, Name, Description, Img, Qty, Category, Price, Discount
                            FROM ShoppingList JOIN Products ON (ID_Product = ID )
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