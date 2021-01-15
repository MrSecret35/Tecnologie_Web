<?php

session_start();

if (session_id() == '' || !isset($_SESSION) || !isset($_SESSION["ID"])) {
    header('Location: ../html/login.html');
    exit;
}

try{
    $db = new PDO("mysql:dbname=bestecommerceever;host=localhost:3306", "root", "");

    $id= $_SESSION["ID"];
    $result= $db->query("SELECT *
                            FROM Addresses
                            WHERE ID_User = $id");
    $result= $result->fetchAll(PDO::FETCH_ASSOC);
    
    print json_encode($result);
    
}catch(PDOException $ex){
    die('Could not connect: ' . $ex->getMessage());
}

?>