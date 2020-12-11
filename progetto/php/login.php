<?php 

if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != "POST") {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request - This service accepts only POST requests.");
}

try {
    $db = new PDO("mysql:dbname=bestecommerceever;host=localhost:3306", "root", "");
    $mail= $db->quote($_POST["EMail"]);
    $psw= $db->quote($_POST["Psw"]);

    $id_user= $db->query("SELECT ID,Psw FROM Users WHERE EMail LIKE $mail");

    print "{\n \"result\": ";
    $result= $id_user->fetch();

    if($result==FALSE){
        print "\"FALSE\", \n";
        print " \"StrErr\": \"Utente non trovato\" ";
    }else if(strcmp($result["Psw"] , $_POST["Psw"]) ==0){
        print "\"TRUE\", \n";
        print " \"StrErr\": \"\" ";
        session_start();
        $_SESSION["ID"]= $result["ID"];
    }else{
        print "\"FALSE\", \n";
        print " \"StrErr\": \"Password Errata\" ";
    }
    print "}";

} catch(PDOException $ex){
    die('Could not connect: ' . $ex->getMessage());
}

?>