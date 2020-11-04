<?php include "top.html"; ?>

<h1>Matches for <?= $_GET["name"]; ?></h1>


<?php // Ricerco nel file singles.txt i dati associati all'utente scelto
    $info = array(); //array contenete le informazioni sull'user
    foreach(explode("\n" , file_get_contents("singles.txt")) as $stringa){
        $infotmp = explode("," , $stringa);
        if(trim($infotmp[0]) == $_GET["name"]){
            $info= $infotmp;
        }
    }
?>

<?php // Ricerco nel file singles.txt i match per l'utente scelto
    foreach(explode("\n" , file_get_contents("singles.txt")) as $stringa){
        $infotmp = explode("," , $stringa);
        //controllo ogni utente se rispetta i requisiti
        if($infotmp!= null && count($infotmp)==7
            && $infotmp[0] != $info[0]  
            && $infotmp[1] != $info[1]
            && $infotmp[2] >= $info[5] && $infotmp[2] <= $info[6]
            && simili($infotmp[3], $info[3])
            && $infotmp[4] == $info[4]){
                
?>
<div class="match">
    <p><img src="https://courses.cs.washington.edu/courses/cse190m/12sp/homework/4/user.jpg" alt="UserImg"> <?= $infotmp[0]; ?> </p>
    <ul>
        <li><strong>gender:</strong><?= $infotmp[1]; ?></li>
        <li><strong>age:</strong><?= $infotmp[2]; ?></li>
        <li><strong>type:</strong><?= $infotmp[3]; ?></li>
        <li><strong>OS:</strong><?= $infotmp[4]; ?></li>
    </ul>
</div>

<?php
        }
    }
?>

<?php /* controllo di 2 stringhe(Personalità) se contengono almeno una lettera uguale nella stessa posizione*/
    function simili($s1, $s2){
        for($i=0; $i<4; $i++){
            if($s1[$i] == $s2[$i]){return true;}
        }
        return false;
    }
?>


<?php include "bottom.html"; ?>