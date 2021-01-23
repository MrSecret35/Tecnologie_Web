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

<script src= "../js/ordersList.js" ></script>

</head>
<body>

<?php include("../html/banner.html");?>

<hr>
<div id="body-block">
<span class="ErrorSTR"></span>
    <h1>Ordini Effettuati</h1>
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
        </li>
        -->
    </ul>
    <button id="homeBTN" class="button">Home</button>
    <button id="myBTN" class="button">My Page</button>
</div>
<hr>

<?php include("../html/bottom.html"); ?>