<?php

if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != "POST") {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request.");
}

if (!isset($_GET["Name"]) || !isset($_GET["Desc"]) || !isset($_GET["Qty"]) || !isset($_GET["Cat"]) || !isset($_GET["Price"])) {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid data.");
}

session_start();

if (session_id() == '' || !isset($_SESSION) || !isset($_SESSION["ID"])) {
    header('Location: ../html/login.html');
    exit;
}

try{

    
    $db = new PDO("mysql:dbname=bestecommerceever;host=localhost:3306", "root", "");
    
    $name= $db->quote($_GET["Name"]);
    $desc= $db->quote($_GET["Desc"]);
    $img= addslashes(file_get_contents($_FILES['img']['tmp_name']));
    $qty= $db->quote($_GET["Qty"]);
    $cat= $db->quote($_GET["Cat"]);
    $price= $db->quote($_GET["Price"]);
    $id= $_SESSION["ID"];

    $result=$db->query("INSERT INTO Products(Name,Description,Img,Qty,Category,Price,Discount,ID_Seller)
                VALUES ($name, $desc, '{$img}', $qty, $cat, $price, 0, $id); ");

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