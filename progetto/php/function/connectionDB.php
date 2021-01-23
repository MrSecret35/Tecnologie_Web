<?php
/*
    @autor: Giorgio Mecca
    Matricola : 880847
*/
/*
    file che forniscec un'unicca funzione connect()
    che connette al DB e restituisce l'elemento PDO
*/
function connect(){
    return new PDO("mysql:dbname=bestecommerceever;host=localhost:3306", "root", "");
}
?>