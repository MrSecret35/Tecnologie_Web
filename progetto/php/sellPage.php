<?php 

session_start();

if (session_id() == '' || !isset($_SESSION) || !isset($_SESSION["ID"])) {
    header('Location: ../html/login.html');
    exit;
}
?>
<?php include("../html/top.html");?>
<script src= "../js/sellPage.js" ></script>
<link href="../css/sellPage.css" type="text/css" rel="stylesheet">

</head>
<body>

<?php include("../html/banner.html");?>

<hr>
<div id="body-block">

    <div id="sell_div">
        <h1>Dati nuovo Prodotto:</h1>

        <ul>
            <li>Nome: <span id="ErrorStrName" class="ErrorStr"></span>
                <input class="input" id="name" type="text" size="64"></li>

            <li>Descrizione: <span id="ErrorStrDesc"  class="ErrorStr"></span>
                <textarea class="input" id="desc" cols="64"></textarea></li>

            <li>Immagine: <span id="ErrorStrImg"  class="ErrorStr"></span>
                <input class="input" id="img" type="file" accept=".jpg, .jpeg, .png"></li>

            <li>Quantita': <span id="ErrorStrQty"  class="ErrorStr"></span>
                <input class="input" id="qty" type="number" size="3" min="0" max="999" ></li>

            <li>Categoria: <span id="ErrorStrCat"  class="ErrorStr"></span>
                <select class="input" id="category"></select></li>

            <li>Prezzo: '€' <span id="ErrorStrPrice"  class="ErrorStr"></span>
                <input class="input" id="price" type="number" size="8"  min="0" placeholder="'€'" maxlength="10"></li>
        </ul>
        <button class="button" id="newProductBTN">Inserisci</button>
        <span id="ErrorStrIns"  class="ErrorStr"></span>
    </div>
    
</div>
<hr>

<?php include("../html/bottom.html"); ?>