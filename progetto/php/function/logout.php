<?php
/*
    @autor: Giorgio Mecca
    Matricola : 880847
*/
/*
    funzione che effettua il logout/
    distrugge e termina una sessione
*/

session_start();

session_unset();   
session_destroy();

header("location: ../../php/index.php");

?>