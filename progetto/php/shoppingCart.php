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
<?php include("../html/top.html");?>
<link href="../css/productList.css" type="text/css" rel="stylesheet">

<script src= "../js/shoppingCart.js" ></script>
<link href="../css/shoppingCart.css" type="text/css" rel="stylesheet">

</head>
<body>

<?php include("../html/banner.html");?>

<hr>
<div id="body-block">
<span class="ErrorSTR"></span>
    <h1>Carrello</h1>
    <ul>
        <!--
        <li>
            <a href="">
            <span>
                <div id="div_img_product">
                    <img src="" alt="">
                </div>
                <div id="div_Str_product">
                    ciaooo come vaaaa
                </div>
            </span>
            </a>
                <div id="div_choise_product">
                    <select name="qty">
                        <option>1</option>
                        <option>2</option>
                    </select>
                    <button>Rimuovi</button>
                </div>
        </li>
    -->
    </ul>
    <hr>
    <button id="order" class="button">Ordina</button>
</div>
<hr>

<?php include("../html/bottom.html"); ?>