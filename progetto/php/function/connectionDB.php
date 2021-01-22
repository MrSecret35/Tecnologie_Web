<?php

function connect(){
    return new PDO("mysql:dbname=bestecommerceever;host=localhost:3306", "root", "");
}
?>