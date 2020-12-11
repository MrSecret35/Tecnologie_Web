<?php
/*
if (session_id() == '' || !isset($_SESSION) || !isset($_SESSION["ID"])) {
    header('Location: ../html/login.html');
    exit;
}
*/
if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != "GET") {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request.");
}

try{
    $db = new PDO("mysql:dbname=bestecommerceever;host=localhost:3306", "root", "");

    if(isset($_GET["Str_Product"])){

        $str= $_GET["Str_Product"];
        $str= $db->quote('%'.$str.'%');

        $result= $db->query("SELECT *
                             FROM Products
                             WHERE Name LIKE $str OR Category LIKE $str");
    }else if(isset($_GET["ID_Product"])) {
        $ID= $_GET["ID_Product"];
        $ID= $db->quote('%'.$str.'%');

        $result= $db->query("SELECT *
                             FROM Products
                             WHERE ID = $ID");
    }
    //print "{\n";
    print json_encode($result->fetchAll(PDO::FETCH_ASSOC));
    //print "\n}";
}catch(PDOException $ex){
    die('Could not connect: ' . $ex->getMessage());
}

?>