<?php

if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != "GET") {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request - This service accepts only GET requests.");
}

try {
	$imdb = new PDO("mysql:dbname=imdb;host=localhost:3306", "root", "");
} catch(PDOException $ex){
    die('Could not connect: ' . $ex->getMessage());
}
$firstName = $imdb->quote($_GET["firstname"]. "%");
$lastName  =  $imdb->quote($_GET["lastname"]);
try{
    $id_actor= $imdb->query("WITH idTA AS (
                                SELECT *
                                FROM actors
                                WHERE first_name LIKE $firstName AND last_name LIKE $lastName
                                )
                            SELECT MIN(id) AS id
                            FROM idTA
                            WHERE film_count = (SELECT MAX(film_count) FROM idTA)");
    
}catch(PDOException $ex){
    die("Query failed: " . $ex->getMessage());
    
}
foreach($id_actor As $row){
    $id_actor = $imdb->quote($row["id"]);
}
try {
    if (isset($_REQUEST["all"]) ) {
        # prepare a SQL query on the database
        $results = $imdb->query("SELECT movies.name, year 
            FROM movies JOIN roles on (movie_id = movies.id) JOIN actors on (actor_id = actors.id) 
            WHERE actors.id = $id_actor ");
        
    }else{
        
        $results = $imdb->query("SELECT movies.name, year 
            FROM movies JOIN roles on (movie_id = movies.id) JOIN actors on (actor_id = actors.id) 
            WHERE actors.id = $id_actor  && movies.id IN (  SELECT movies.id
                                                            FROM movies JOIN roles on (movie_id = movies.id) JOIN actors on (actor_id = actors.id) 
                                                            WHERE first_name LIKE 'Kevin' && last_name LIKE 'Bacon'
                                                            )
            ");
    }
} catch(PDOException $ex){
    die("Query failed: " . $ex->getMessage());
    
}

$orderRow=array(); 
$i=0;
foreach($results as $row){
    $orderRow[$i]=$row;
    
    for($j=$i-1; $j>=0; $j--){
        if($orderRow[$j]["year"] < $orderRow[$j+1]["year"]){
            $tmp= $orderRow[$j+1];
            $orderRow[$j+1]= $orderRow[$j];
            $orderRow[$j]= $tmp;
        }
    }
    $i++;
}

$c=0; $col= count($orderRow);
print "{\n  \"name\": {\n \"firstname\": \"$_GET[firstname]\", \n \"lastname\": \"$_GET[lastname]\" },";


print "\n  \"film\": [\n";
foreach($orderRow as $row){
    print "    {\"number\": \"$c\",\"title\": \"$row[name]\", \"year\": \"$row[year]\" }";
    if($c != $col -1) print ",";
    print "\n";
    $c++;
}
print "  ]\n}\n";

?>