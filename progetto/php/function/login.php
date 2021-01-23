<?php 
/*
    @autor: Giorgio Mecca
    Matricola : 880847
*/
/*
    funzione php per effettuare il login e creare la sessione
*/

if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != "POST") {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request - This service accepts only POST requests.");
}

if (!isset($_POST["EMail"]) || !isset($_POST["Psw"])) {
	header("HTTP/1.1 400 Invalid Data");
	die("ERROR 400: Invalid data.");
}
try {
    include("connectionDB.php");
    $db =connect();
    
    $mail= $db->quote($_POST["EMail"]);
    $psw= $db->quote($_POST["Psw"]);

    $id_user= $db->query("SELECT ID,Psw FROM Users WHERE EMail LIKE $mail");

    
    print "{\n \"result\": ";
    $result= $id_user->fetch();
    $id= $result["ID"];
    

    if($result==FALSE){
        print "\"FALSE\", \n";
        print " \"StrErr\": \"Utente non trovato\" ";
    }else if(strcmp($result["Psw"] , $_POST["Psw"]) ==0){
        print "\"TRUE\", \n";
        print " \"StrErr\": \"\" ";

        $userB= $db->query("SELECT * FROM Business WHERE ID = $id")->fetch();

        session_start();//creazioendella sessione
        $_SESSION["ID"]= $id; // inserimento ID nella sessione
        if($userB != FALSE) $_SESSION["UserBusiness"]= TRUE;
        else $_SESSION["UserBusiness"]= FALSE;

    }else{
        print "\"FALSE\", \n";
        print " \"StrErr\": \"Password Errata\" ";
    }
    print "}";

} catch(PDOException $ex){
    die('Could not connect: ' . $ex->getMessage());
}

?>