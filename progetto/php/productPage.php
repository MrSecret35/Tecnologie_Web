<?php 
/*
    @autor: Giorgio Mecca
    Matricola : 880847
*/

session_start();

if (session_id() == '' || !isset($_SESSION) || !isset($_SESSION["ID"]) || !isset($_GET["ID_Product"])) {
    header('Location: ../html/login.html');
    exit;
}

?>
<?php include("../html/top.html");?>
<script src= "../js/productPage.js" ></script>
<link href="../css/productPage.css" type="text/css" rel="stylesheet">

</head>
<body>

<?php include("../html/banner.html");?>

<hr>
<div id="body-block">
    <span class="ErrorSTR"></span>
    <div id="imgDiv">
        <img id="ProductImage" src="" alt="ProductImage">
    </div>
    <div id="ProductData">
        <p id="Name"></p>
        <p id="Desc"></p>
        <p id="Price"></p>
        <p id="Qty"></p>
    </div>
    <div id="SellerData">
        <h1>Seller:</h1>
        <ul>
        </ul>
    </div>
    <div id="buttonDiv">
        <button class="button" id="cart">Aggiungi al carrello</button>
        <button class="button" id="list">Lista Preferiti</button>
    </div>

</div>
<hr>

<?php include("../html/bottom.html"); ?>