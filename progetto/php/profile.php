<?php 
/*
    @autor: Giorgio Mecca
    Matricola : 880847
*/

session_start();

if (session_id() == '' || !isset($_SESSION) || !isset($_SESSION["ID"])) {
    header('Location: ../html/login.html');
    exit;
}

?>
<?php include("../html/top.html"); ?>

<script src= "../js/profile.js" ></script>
<link href="../css/profile.css" type="text/css" rel="stylesheet" >

</head>
<body>

<?php include("../html/banner.html");?>
<hr>

<div id="body-block">
    <?php 
        if($_SESSION["UserBusiness"]==FALSE){
    ?>
    <div class="Info" id="UserInfo">
        <h1>Personal Data</h1>
        <ul>
            <li>Mail: <p id="Mail"></p></li>
            <li>nome: <p id="Name"></p></li>
            <li>Cognome: <p id="Surname"></p></li>
        </ul>
    </div>

    <?php 
        }else{
    ?>
    <div class="Info" id="BusinessInfo">
        <h1>Business Information</h1>
        <ul>
            <li>Mail: <p id="Mail"></p></li>
            <li>Nome: <p id="Name"></p></li>
            <li>Link: <p id="Link"></p></li>
            <li>NUm.Telefono: <p id="NTel"></p></li>
        </ul>
    </div>
    <?php 
        }
    ?>
<hr>
    <div id="Addresses">
        <h1>Indirizzi</h1>
        <!-- Div degli Indirizzi-->
        <span id="AddressStr"></span>
        <!--
        <div class="Address">
            <ul>
                <li>Stato</li>
                <li>Citta'</li>
                <li>Strada</li>
                <li>Numero Civico</li>
            </ul>
        </div>
        <div class="Address">
            <ul>
                <li>Stato1</li>
                <li>Citta'1<li>
                <li>Strada1</li>
                <li>Numero Civico1</li>
            </ul>
        </div>
        -->
        <hr>
        <button id="newAddress">Nuovo Indirizzo</button>
        <div class="Info" id="divNewAddress">
            <h1>Nuovo Indirizzo</h1>
            <span class="ErrorSTR" ></span>
            <ul>
                <li>Stato: <input type="text" id="State"></li>
                <li>Citta': <input type="text" id="City"></li>
                <li>Via: <input type="text" id="Street"></li>
                <li>N.Civico: <input type="text" id="StreetN"></li>
            </ul>
            <button id="addNewAddress">Aggiungi</button>
        </div>
    </div>
<hr id="afterData">
    <div id="DivButtonData">
        <a href="../php/shoppingCart.php"><div class="QuickButton">
            Carrello
            <img src="../img/cart.png" alt="cart">
        </a></div>
        <a href="../php/favoritesList.php"><div class="QuickButton">
            Lista Preferiti
            <img src="../img/star.png" alt="Lista Preferiti">
        </a></div>
        <a href="../php/salesList.php"><div class="QuickButton">
            In Vendita
            <img src="../img/sell.png" alt="Sell">
        </a></div>
        <a href="../php/ordersList.php"><div class="QuickButton">
            Ordini
            <img src="../img/order.png" alt="orders">
        </a></div>
        
    </div>

</div>
<hr>
<?php include("../html/bottom.html"); ?>