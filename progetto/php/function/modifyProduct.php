<?php
/*
    @autor: Giorgio Mecca
    Matricola : 880847
*/
/*
    funzione php per modificare i dati di un Product
*/

session_start();

if (session_id() == '' || !isset($_SESSION) || !isset($_SESSION["ID"])) {
    header('Location: ../../html/login.html');
    exit;
}

if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != "POST") {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request.");
}

if (!isset($_POST["Name"]) || !isset($_POST["Desc"]) || !isset($_POST["Qty"]) || !isset($_POST["Price"]) || !isset($_POST["Discount"])) {
	header("HTTP/1.1 400 Invalid Dats");
	die("ERROR 400: Invalid data.");
}

try{

    
    include("connectionDB.php");
    $db =connect();
    
    $ID_Product=$db->quote($_POST["ID_Product"]);
    $name= $db->quote(htmlspecialchars($_POST["Name"]));
    $desc= $db->quote(htmlspecialchars($_POST["Desc"]));
    $qty= $db->quote(htmlspecialchars($_POST["Qty"]));
    $price= $db->quote(htmlspecialchars($_POST["Price"]));
    $discount= $db->quote(htmlspecialchars($_POST["Discount"]));
    $id= $_SESSION["ID"];

    $result=$db->query("SELECT * FROM Products WHERE ID = $ID_Product AND ID_Seller= $id");

    if($result==FALSE){
        print "{\n \"result\": ";
        print "\"FALSE\", \n";
        print " \"StrErr\": \"Non è possibile modificare quel prodotto\" ";
        print "}";
    }else{

        $result=$db->query("UPDATE Products 
                            SET Name= $name, Description = $desc, Qty = $qty, Price = $price, Discount = $discount
                            WHERE ID = $ID_Product AND ID_Seller= $id");

        if($result==FALSE){
            print "{\n \"result\": ";
            print "\"FALSE\", \n";
            print " \"StrErr\": \"Errore nella modifica del prodotto\" ";
            print "}";
        }else{
            print "{\n \"result\": ";
            print "\"TRUE\", \n";
            print " \"StrErr\": \"\" ";
            print "}";
        }
    }
    
}catch(PDOException $ex){
    die('Could not connect: ' . $ex->getMessage());
}

?>