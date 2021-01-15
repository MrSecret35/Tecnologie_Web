<?php 
$_NAME_DB= "BestECommerceEver";
try{

    //mi connetto al server 
    $db = new PDO("mysql:host=localhost:3306", "root", "");

    //elimino il DB se esiste
    $db->exec("DROP DATABASE IF EXISTS $_NAME_DB");

    //creo/ricreo il db 
    $db->exec("CREATE DATABASE $_NAME_DB");

    //mi connetto al nuovo Database
    $db = new PDO("mysql:dbname=$_NAME_DB;host=localhost:3306", "root", "");
    
    $db->exec("CREATE TABLE Users(
                    ID INT PRIMARY KEY AUTO_INCREMENT,
                    EMail varchar(64) NOT NULL UNIQUE,
                    Psw varchar(20) NOT NULL,
                    Name varchar(64),
                    Surname varchar(64)
                    )");

    $db->exec("CREATE TABLE Business(
                    Name varchar(64) NOT NULL,
                    Description TEXT,
                    Link varchar(64),
                    PhoneN varchar(10),
                    ID INT References Users(ID)
                        ON DELETE CASCADE ON UPDATE CASCADE,
                    PRIMARY KEY (ID)
                    )");
    
    $db->exec("CREATE TABLE Addresses(
                    State varchar(32),
                    City varchar(32),
                    Street varchar(32),
                    StreetN varchar(5),
                    ID_User INT References Users(ID)
                        ON DELETE CASCADE ON UPDATE CASCADE,
                    PRIMARY KEY (ID_User, State, City, Street, StreetN)
                    )");

    $db->exec("CREATE TABLE Categories(
                    Category varchar(64) PRIMARY KEY
                    )");

    $db->exec("CREATE TABLE Products(
                    ID INT PRIMARY KEY AUTO_INCREMENT,
                    Name varchar(32) NOT NULL,
                    Description TEXT,
                    Img BLOB,
                    Qty INT NOT NULL,
                    Category varchar(64) DEFAULT 'Varie',
                    Price INT,
                    Discount INT,
                    ID_Seller INT NOT NULL References Users(ID)
                        ON DELETE CASCADE ON UPDATE CASCADE,
                    FOREIGN KEY (Category) References Categories(Category) 
                        ON DELETE CASCADE ON UPDATE CASCADE
                    )");
    
    $db->exec("CREATE TABLE ShoppingCart(
                    ID_User INT NOT NULL References Users(ID)
                        ON DELETE CASCADE ON UPDATE CASCADE,
                    ID_Product INT NOT NULL References Products(ID)
                        ON DELETE CASCADE ON UPDATE CASCADE,
                    PRIMARY KEY (ID_User, ID_Product)
                    )");
    
    $db->exec("CREATE TABLE ShoppingList(
                    ID_User INT NOT NULL References Users(ID)
                        ON DELETE CASCADE ON UPDATE CASCADE,
                    ID_Product INT NOT NULL References Products(ID)
                        ON DELETE CASCADE ON UPDATE CASCADE,
                    PRIMARY KEY (ID_User, ID_Product)
                    )");

    $db->exec("CREATE TABLE Orders(
                    ID_User INT NOT NULL References Users(ID)
                        ON DELETE CASCADE ON UPDATE CASCADE,
                    ID_Product INT NOT NULL References Products(ID)
                        ON DELETE CASCADE ON UPDATE CASCADE,
                    DataOrder DATE,
                    Qty INT NOT NULL,
                    PRIMARY KEY (ID_User, ID_Product, DataOrder)
                    )");

    $myfile = file_get_contents('../DB_Insert_Query.txt');
    foreach(explode(';', $myfile) as $row){
        $db->query($row);
    }

}catch(PDOException $ex){
    die('Could not connect: ' . $ex->getMessage());
}

?> 