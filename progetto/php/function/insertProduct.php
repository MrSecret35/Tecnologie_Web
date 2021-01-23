<?php
/*
    @autor: Giorgio Mecca
    Matricola : 880847
*/
/*
    funzione php per inserire un nuovo predotto nel DataBase
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

if (!isset($_GET["Name"]) || !isset($_GET["Desc"]) || !isset($_GET["Qty"]) || !isset($_GET["Cat"]) || !isset($_GET["Price"])) {
	header("HTTP/1.1 400 Invalid Data");
	die("ERROR 400: Invalid data.");
}

try{

    
    include("connectionDB.php");
    $db =connect();
    
    $name= $db->quote(htmlspecialchars($_GET["Name"]));
    $desc= $db->quote(htmlspecialchars($_GET["Desc"]));
    if(isset($_SESSION["img"])) $img= "'{" + addslashes(file_get_contents($_FILES['img']['tmp_name'])) + "}'";
    else $img="NULL";
    $qty= $db->quote(htmlspecialchars($_GET["Qty"]));
    $cat= $db->quote(htmlspecialchars($_GET["Cat"]));
    $price= $db->quote(htmlspecialchars($_GET["Price"]));
    $id= $_SESSION["ID"];

    $result=$db->query("INSERT INTO Products(Name,Description,Img,Qty,Category,Price,Discount,ID_Seller)
                VALUES ($name, $desc, $img, $qty, $cat, $price, 0, $id); ");

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