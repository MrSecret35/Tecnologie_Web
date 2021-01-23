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

<script src= "../js/salesList.js" ></script>
<link href="../css/salesList.css" type="text/css" rel="stylesheet">

</head>
<body>

<?php include("../html/banner.html");?>

<hr>
<div id="body-block">
<span class="ErrorSTR"></span>
    <h1>Oggetti in Vendita</h1>
    <ul>
        <!--
        <li>
            <span>
                <div id="div_img_product">
                    <img src="../img/img.png" alt="">
                </div>
                <div id="div_Str_product">
                    <input class="input" type="text" value="nome">
                    <textarea class="input" id="desc" cols="64"></textarea>
                    <table>
                        <tr>
                            <td><p>Quantità:</p></td>
                            <td><p>Prezzo:</p></td>
                            <td><p>Sconto:</p></td>
                        </tr>
                        <tr>
                            <td><input class="input" type="number" value="12"></td>
                            <td><input class="input" type="number" value="2"></td>
                            <td><input class="input" type="number" value="12"></td>
                        </tr>
                    </table>
                </div>
            </span>
            <div id="div_choise_product">
                <button id="modify">Modifica</button>
                <button id="remove">Rimuovi</button>
            </div>
        </li>
        -->
        
    </ul>
    <button id="homeBTN" class="button">Home</button>
    <button id="myBTN" class="button">My Page</button>
</div>
<hr>

<?php include("../html/bottom.html"); ?>