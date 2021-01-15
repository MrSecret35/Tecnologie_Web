<?php

session_start();

if (session_id() == '' || !isset($_SESSION) || !isset($_SESSION["ID"])) {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request.");
}

try{
    $db = new PDO("mysql:dbname=bestecommerceever;host=localhost:3306", "root", "");

    $id= $_SESSION["ID"];
    print "{\n \"Type\": ";
    if($_SESSION["UserBusiness"] == FALSE){
        print "\"User\",\n";
        $result= $db->query("SELECT *
                            FROM Users
                            WHERE ID = $id");
    }else{
        print "Business,\n";
        $result= $db->query("SELECT *
                            FROM Business
                            WHERE ID = $id");
    }
    print "\"Data\": ";
    if($result!=FALSE){
        $result= $result->fetch(PDO::FETCH_ASSOC);
        
        print json_encode($result);
    }else{
        die("Invalid Session");
    }
    print "}";
}catch(PDOException $ex){
    die('Could not connect: ' . $ex->getMessage());
}

?>