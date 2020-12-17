<?php

if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != "GET") {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request.");
}

try{
    $db = new PDO("mysql:dbname=bestecommerceever;host=localhost:3306", "root", "");

    $result= $db->query("SELECT *
                            FROM Categories");
    $result= $result->fetchAll(PDO::FETCH_ASSOC);
    
    print json_encode($result);
    
}catch(PDOException $ex){
    die('Could not connect: ' . $ex->getMessage());
}

?>