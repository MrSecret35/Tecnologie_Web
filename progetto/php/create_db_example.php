<?php 
$_NAME_DB= "BestECommerceEver";
try{

    //mi connetto al server 
    $imdb = new PDO("mysql:host=localhost:3306", "root", "");

    //elimino il DB se esiste
    $imdb->exec("DROP DATABASE IF EXISTS $_NAME_DB");

    //creo/ricreo il db 
    $imdb->exec("CREATE DATABASE $_NAME_DB");

    //mi connetto al nuovo Database
    $imdb = new PDO("mysql:dbname=$_NAME_DB;host=localhost:3306", "root", "");
    
    $imdb->exec("CREATE TABLE Users(
                    ID INT PRIMARY KEY AUTO_INCREMENT,
                    EMail varchar(64) NOT NULL UNIQUE,
                    Psw varchar(20) NOT NULL,
                    Name varchar(64),
                    Surname varchar(64)
                    )");

    $imdb->exec("CREATE TABLE Business(
                    Name varchar(64) NOT NULL,
                    Description TEXT,
                    Link varchar(64),
                    PhoneN varchar(10),
                    ID INT References Users(ID),
                    PRIMARY KEY (ID)
                    )");
    
    $imdb->exec("CREATE TABLE Addresses(
                    State varchar(32),
                    City varchar(32),
                    Street varchar(32),
                    StreetN varchar(5),
                    ID_User INT References Users(ID),
                    PRIMARY KEY (ID_User, State, City, Street, StreetN)
                    )");

    $imdb->exec("CREATE TABLE Categories(
                    Category varchar(64) PRIMARY KEY
                    )");

    $imdb->exec("CREATE TABLE Products(
                    ID INT PRIMARY KEY AUTO_INCREMENT,
                    Name varchar(32) NOT NULL,
                    Description TEXT,
                    Img BLOB,
                    Qty INT NOT NULL,
                    Category varchar(64) References Categories(Category),
                    Price INT,
                    Discount INT,
                    ID_Seller INT NOT NULL References Users(ID)
                    )");
    
    $imdb->exec("CREATE TABLE ShoppingCart(
                    ID_Seller INT NOT NULL References Users(ID),
                    ID_Product INT NOT NULL References Products(ID),
                    Qty INT NOT NULL,
                    PRIMARY KEY (ID_Seller, ID_Product)
                    )");
    
    $imdb->exec("CREATE TABLE ShoppingList(
                    ID_Seller INT NOT NULL References Users(ID),
                    ID_Product INT NOT NULL References Products(ID),
                    PRIMARY KEY (ID_Seller, ID_Product)
                    )");

    $imdb->exec("CREATE TABLE Orders(
                    ID_Seller INT NOT NULL References Users(ID),
                    ID_Product INT NOT NULL References Products(ID),
                    DataOrder DATE,
                    Qty INT NOT NULL,
                    PRIMARY KEY (ID_Seller, ID_Product, DataOrder)
                    )");

    $myfile = file_get_contents('../DB_Insert_Query.txt');
    foreach(explode(';', $myfile) as $row){
        $imdb->query($row);
    }

}catch(PDOException $ex){
    die('Could not connect: ' . $ex->getMessage());
}

?> 