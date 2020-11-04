<?php include "top.html"; ?>

<?php
    $current= file_get_contents("singles.txt");//prendo i dati presenti nel file singles.txt

    //creo la stringa contenente i dati del nuovo utente
    $string= trim($_POST["name"]) . "," . trim($_POST["S"]) . "," 
            .trim($_POST["age"]) . "," .trim($_POST["personality"]) . "," 
            .trim($_POST["OS"]) . "," .trim($_POST["minAge"]) . "," .trim($_POST["maxAge"]) ;
    
    //allego la nuova stringa al vecchio contenuto
    $current= $current . $string . "\n";
    file_put_contents("singles.txt", $current);//scrivo il contenuto sul file
?>

<h1>Thamk you!</h1>
<p>Welcome to NerdLuv, <?= $_POST["name"]; ?>!</p>
<p>Now <a href="matches.php">log in to see your matches!</a></p>
<?php include "bottom.html"; ?>