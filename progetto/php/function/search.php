<?php
if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != "GET") {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request.");
}

try{
    include("connectionDB.php");
    $db =connect();
    
    $rows = array();

    if(isset($_GET["Str_Product"])){

        $str= $_GET["Str_Product"];
        $str= $db->quote('%'.$str.'%');

        $result= $db->query("SELECT *
                             FROM Products
                             WHERE Name LIKE $str OR Category LIKE $str");
        //$result= $result->fetchAll(PDO::FETCH_ASSOC);

        
        
        while($row = $result->fetch()){
            
            if($row["Img"] != null){
                $new_row["ID"]= $row["ID"];
                $new_row["Name"]= $row["Name"];
                $new_row["Description"]= $row["Description"];
                $new_row["Img"]= base64_encode($row["Img"]);
                $new_row["Qty"]= $row["Qty"];
                $new_row["Category"]= $row["Category"];
                $new_row["Price"]= $row["Price"];
                $new_row["Discount"]= $row["Discount"];
                $new_row["ID_Seller"]= $row["ID_Seller"];    
                    
                $rows[]= $new_row;
            }else{
                $rows[]= $row;
            }
        }

        if(count($rows) != 0) {
            
            $cat= $rows[0]["Category"];
            $cat= $db->quote($cat);
            $result1= $db->query("SELECT *
                                FROM Products
                                WHERE Category LIKE $cat 
                                    AND ID NOT IN (SELECT ID
                                                    FROM Products
                                                    WHERE Name LIKE $str OR Category LIKE $str)");
            if($result1 != FALSE){
                $rows2 = array();
                
                while($row1 = $result1->fetch()){
                    if($row1["Img"] != null){
                        
                        $new_row["ID"]= $row1["ID"];
                        $new_row["Name"]= $row1["Name"];
                        $new_row["Description"]= $row1["Description"];
                        $new_row["Img"]= base64_encode($row1["Img"]);
                        $new_row["Qty"]= $row1["Qty"];
                        $new_row["Category"]= $row1["Category"];
                        $new_row["Price"]= $row1["Price"];
                        $new_row["Discount"]= $row1["Discount"];
                        $new_row["ID_Seller"]= $row1["ID_Seller"];
                        
                        
                        $rows2[]= $new_row;
                    }else{
                        
                        $rows2[]= $row1;
                        
                    }
                    
                }
                
                   
                
               
                $rows= array_merge($rows,$rows2);
            }
            
            
        }
        
    }else if(isset($_GET["ID_Product"])) {
        //$ID= $_GET["ID_Product"];
        $ID= $db->quote($_GET["ID_Product"]);

        $result= $db->query("SELECT *
                             FROM Products
                             WHERE ID = $ID");
        //$result= $result->fetchAll(PDO::FETCH_ASSOC);
        while($row = $result->fetch()){
        
            if($row["Img"] != null){
                $new_row["ID"]= $row["ID"];
                $new_row["Name"]= $row["Name"];
                $new_row["Description"]= $row["Description"];
                $new_row["Img"]= base64_encode($row["Img"]);
                $new_row["Qty"]= $row["Qty"];
                $new_row["Category"]= $row["Category"];
                $new_row["Price"]= $row["Price"];
                $new_row["Discount"]= $row["Discount"];
                $new_row["ID_Seller"]= $row["ID_Seller"];
    
                
                $rows[]= $new_row;
            }else{
                $rows[]= $row;
            }
        }
    }
    //print "{\n";
    print json_encode($rows);
    //print "\n}";
    
}catch(PDOException $ex){
    die('Could not connect: ' . $ex->getMessage());
}

?>