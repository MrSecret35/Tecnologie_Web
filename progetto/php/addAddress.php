<?php 

session_start();

if (session_id() == '' || !isset($_SESSION) || !isset($_SESSION["ID"])) {
    header('Location: ../html/login.html');
    exit;
}


$db = new PDO("mysql:dbname=bestecommerceever;host=localhost:3306", "root", "");

$state=$db->quote($_GET["State"]);
$city=$db->quote($_GET["City"]);
$street=$db->quote($_GET["Street"]);
$streetN=$db->quote($_GET["StreetN"]);
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


?>