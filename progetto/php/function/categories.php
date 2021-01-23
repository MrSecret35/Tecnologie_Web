<?php
/*
    @autor: Giorgio Mecca
    Matricola : 880847
*/
/*
    funzione php che restituiscce un array Json contenente 
    tutte le categorie presenti nella tabella Categories del BD
*/

try{
    include("connectionDB.php");
    $db =connect();

    $result= $db->query("SELECT *
                            FROM Categories");
    $result= $result->fetchAll(PDO::FETCH_ASSOC);
    
    print json_encode($result);
    
}catch(PDOException $ex){
    die('Could not connect: ' . $ex->getMessage());
}

?>