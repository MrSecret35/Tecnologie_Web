<?php

if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != "GET") {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request.");
}

session_start();

if (session_id() == '' || !isset($_SESSION) || !isset($_SESSION["ID"])) {
    header('Location: ../html/login.html');
    exit;
}

try{

    $db = new PDO("mysql:dbname=bestecommerceever;host=localhost:3306", "root", "");
    
    $id= $_SESSION["ID"];

    $products=$db->query("SELECT * FROM ShoppingCart JOIN Products ON (ID_Product=ID) 
                        WHERE ID_User= $id");
    
    $result=FALSE;

    while($p= $products->fetch()){
        $ID_Product= $p["ID_Product"];
        $qty= $_GET[$ID_Product];

        

        $new_qty= $p["Qty"]-$qty;
        if($new_qty >= 0){
            $db->query("UPDATE Products SET Qty = $new_qty  WHERE ID = $ID_Product");

            $datetime = $db->quote(date_create()->format('Y-m-d H:i:s'));
            
            $result= $db->query("DELETE FROM ShoppingCart WHERE ID_Product = $ID_Product AND ID_User= $id");
            $result= $db->query("INSERT INTO Orders VALUES ($id, $ID_Product, $datetime, $qty) ");
        }else $result=FALSE;
        
    }

    if($result==FALSE){
        print "{\n \"result\": ";
        print "\"FALSE\", \n";
        print " \"StrErr\": \"Impossibile Registrare il Prodotto\" ";
        print "}";
    }else{
        print "{\n \"result\": ";
        print "\"TRUE\", \n";
        print " \"StrErr\": \"\" ";
        print "}";
    }
    
}catch(PDOException $ex){
    die('Could not connect: ' . $ex->getMessage());
}

?>