<?php
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
        $result= $result->fetchAll(PDO::FETCH_ASSOC);
        if($result!=FALSE) {
            $cat= $result[0]["Category"];
            $cat= $db->quote($cat);
            $result1= $db->query("SELECT *
                                FROM Products
                                WHERE Category LIKE $cat 
                                    AND ID NOT IN (SELECT ID
                                                    FROM Products
                                                    WHERE Name LIKE $str OR Category LIKE $str)");
            $result1= $result1->fetchAll(PDO::FETCH_ASSOC);

            $result= array_merge($result,$result1);
        }
        
    }else if(isset($_GET["ID_Product"])) {
        $ID= $_GET["ID_Product"];
        $ID= $db->quote('%'.$str.'%');

        $result= $db->query("SELECT *
                             FROM Products
                             WHERE ID = $ID");
        $result= $result->fetchAll(PDO::FETCH_ASSOC);
    }

    //print "{\n";
    print json_encode($result);
    //print "\n}";
    
}catch(PDOException $ex){
    die('Could not connect: ' . $ex->getMessage());
}

?>