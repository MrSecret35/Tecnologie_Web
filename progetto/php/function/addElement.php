<?php
session_start();

if (session_id() == '' || !isset($_SESSION) || !isset($_SESSION["ID"])) {
    header('Location: ../../html/login.html');
    exit;
}

if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != "GET") {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request.");
}

if (!isset($_GET["ID_Product"]) || !isset($_GET["To"])) {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid data.");
}


try{
    include("connectionDB.php");
    $db =connect();
    
    $ID_Product= $db->quote($_GET["ID_Product"]);
    $ID_User = $_SESSION["ID"];

    $result=FALSE;
    if($_GET["To"] == "Cart"){
        $result= $db->query("SELECT * FROM ShoppingCart WHERE ID_User= $ID_User AND ID_Product = $ID_Product");
    
        $result= $result->fetch(PDO::FETCH_ASSOC);
        if($result == FALSE){
            
            $result=$db->query("INSERT INTO ShoppingCart VALUES ($ID_User, $ID_Product); ");
        }
    }else if($_GET["To"] == "List"){
        $result= $db->query("SELECT * FROM ShoppingList WHERE ID_User= $ID_User AND ID_Product = $ID_Product");
    
        $result= $result->fetch(PDO::FETCH_ASSOC);
        if($result == FALSE){
            $result=$db->query("INSERT INTO ShoppingList VALUES ($ID_User, $ID_Product); ");
        }
    }
    
    if($result==FALSE){
        print "{\n \"result\": ";
        print "\"FALSE\", \n";
        print " \"StrErr\": \"Impossibile Aggiungere il Prodotto\" ";
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