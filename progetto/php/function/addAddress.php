<?php
/*
    @autor: Giorgio Mecca
    Matricola : 880847
*/ 
/*
    funzione utilizzata per l'aggiunta di un nuovo Indirizzo 
    nella tabella Adresses del DataBase e sarà associato all'utente ID della Session
*/
session_start();

if (session_id() == '' || !isset($_SESSION) || !isset($_SESSION["ID"])) {
    header('Location: ../../html/login.html');
    exit;
}

if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != "GET") {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request.");
}

if (!isset($_GET["State"]) || !isset($_GET["City"]) || !isset($_GET["Street"]) || !isset($_GET["StreetN"])) {
	header("HTTP/1.1 400 Invalid Data");
	die("ERROR 400: Invalid data.");
}

try{
    include("connectionDB.php");
    $db =connect();

    $state=$db->quote(htmlspecialchars($_GET["State"]));
    $city=$db->quote(htmlspecialchars($_GET["City"]));
    $street=$db->quote(htmlspecialchars($_GET["Street"]));
    $streetN=$db->quote(htmlspecialchars($_GET["StreetN"]));
    $id=$_SESSION["ID"];

    $result= $db->query("SELECT * FROM Addresses WHERE State LIKE $state AND City LIKE $city AND Street LIKE $street AND StreetN LIKE $streetN AND ID_User= $id");
    if($result->fetch() == FALSE){

        $db->query("INSERT INTO Addresses VALUES ($state,$city,$street,$streetN,$id);");

        print "{\n \"result\": ";
        print "\"TRUE\", \n";
        print " \"StrErr\": \"\" ";
        print "}";

    }else{

        print "{\n \"result\": ";
        print "\"FALSE\", \n";
        print " \"StrErr\": \"Indirizzo gia' registrato\" ";
        print "}";
    }
}catch(PDOException $ex){
    die('Could not connect: ' . $ex->getMessage());
}

?>