<?php
/*
    @autor: Giorgio Mecca
    Matricola : 880847
*/
/*
    funzione php per ottenere tutti i prodotti che ha messo in vendita l'utente della Session
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


    $result= $db->query("SELECT *
                            FROM Products
                            WHERE ID_Seller= $id;");

    //$result= $result->fetchAll();
    $rows = array();

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