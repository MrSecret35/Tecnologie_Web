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

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>

<script src= "../js/home.js" ></script>
<link href="../css/home.css" type="text/css" rel="stylesheet" >
  
</head>
<body>

<?php include("../html/banner.html");?>

<hr>
<div id="body-block">
    <span class=".ErrorStr"></span>
    <div id="search">
        <input id="search_bar" type="text">
        <img id="search_icon" src="../img/search.png" alt="search_icon">
    </div>
    <div id="choices">
        <ul id="categories">

        </ul>
        
        <input type="range" id="nfp" min="1" max="25" step="2" value="">
        <span id="valRange"></span>
    </div>
    <div id="products">

        <!--
        <div class="product-block">
        <ul>
            <li>
            <span class="product">
                <div>Immagine</div>
                <div>Nome e Prezzo</div>
            </span>
            </li>
            <li>
            </li>
        </ul>
        </div>
        -->
        <span id="notification"></span>
        <ul id="ul_products">

        </ul>
        <div id="page_products">
            <ul>
            </ul>
        </div>
    </div>
    
</div>
<hr>

<?php include("../html/bottom.html"); ?>
