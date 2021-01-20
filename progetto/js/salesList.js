$(function(){
    showProduct();

    $("#homeBTN").click(function(){  location.href= "../php/index.php";});
    $("#myBTN").click(function(){  location.href= "../php/profile.php";});
}); 

/*
 * funzione che richiede al server la lista dei prodotti messi in vendita
 */
function showProduct(){
    $.ajax({
        url: "../php/sale.php",
        type: "GET",
        datatype: "json",
        success: showListProduct,
        error: function(){$(".ErrorSTR").html("Errore Momentaneo, \n Riprovare in seguito");}
    });
}

/*
* crea e imposta gli elem(<li>) di una lista
* json: lista di oggetti da mostrare
*/ 
function showListProduct(json){
    var data= JSON.parse(json);
    $("#body-block ul").empty();

    for(i= 0; i< data.length; i++){
        var element= data[i];

        var li= $('<li></li>');     li.attr('id', element.ID_Product);

            var span = $('<span></span>');

                var div1 = $('<div></div>');    div1.attr('id', 'div_img_product');
                    var img = $('<img></img>')
                    if (element.Img != null) img.attr("src", "data:image/  png;base64," + element.Img);
                    else img.attr("src", "../img/img.png");
                div1.append(img);

                var div2 = $('<div></div>');    div2.attr('id', 'div_Str_product');
                    var inputName = $('<input></input>');
                        inputName.attr('type', 'text');    
                        inputName.attr('class', 'input');   
                        inputName.attr('id', element.ID + "_Name");
                        inputName.attr('readonly', true);  
                        inputName.val(element.Name);

                    var inputDesc = $('<textarea></textarea>');   
                        inputDesc.attr('class', 'input');   
                        inputDesc.attr('id', element.ID + "_Desc");
                        inputDesc.attr('cols', '64');
                        inputDesc.attr('readonly', true);
                        inputDesc.val(element.Description);

                    var table= $('<table></teble>');
                        var tr1 =  $("<tr><td><p>Quantità:</p></td><td><p>Prezzo:</p></td><td><p>Sconto:</p></td></tr>");
                        var tr2 = $('<tr></tr>');
                            var td1 = $('<td></td>');   var td2 = $('<td></td>');   var td3 = $('<td></td>');
                            var inputQty = $('<input></input>');
                                inputQty.attr('type', 'number');    
                                inputQty.attr('class', 'input');   
                                inputQty.attr('id', element.ID + "_Qty");
                                inputQty.attr('readonly', true);  
                                inputQty.val(element.Qty);
                            td1.append(inputQty);
                            var inputPrice = $('<input></input>');
                                inputPrice.attr('type', 'number');    
                                inputPrice.attr('class', 'input');   
                                inputPrice.attr('id', element.ID + "_Price");
                                inputPrice.attr('readonly', true);  
                                inputPrice.val(element.Price);
                            td2.append(inputPrice);
                            var inputDiscount = $('<input></input>');
                                inputDiscount.attr('type', 'number');    
                                inputDiscount.attr('class', 'input');   
                                inputDiscount.attr('id', element.ID + "_Discount");
                                inputDiscount.attr('readonly', true);  
                                inputDiscount.val(element.Discount);
                            td3.append(inputDiscount);
                        tr2.append(td1);    tr2.append(td2);    tr2.append(td3);

                    table.append(tr1);  table.append(tr2);

                div2.append(inputName);     div2.append(inputDesc);     div2.append(table);

            span.append(div1);  span.append(div2);

            li.append(span);
        
            var div11 = $('<div></div>');    div11.attr('id', 'div_choise_product');

            
            var btnM = $('<button></button>'); btnM.attr('id', element.ID + "_modifyBTN");
            btnM.html("Modifica");
            btnM.click(abilitaModificaDati);

            var btnSM = $('<button></button>'); btnSM.attr('id', element.ID + "_sendmodBTN");
            btnSM.html("Conferma Modifica");
            btnSM.css('display', "none");
            btnSM.click(modProduct);

            var btnR = $('<button></button>'); btnR.attr('id', element.ID+ '_removeBTN');
            btnR.html("Rimuovi");
            btnR.click(removeProduct);
            
            div11.append(btnM);
            div11.append(btnSM);
            div11.append(btnR);

        li.append(div11);


        $("#body-block ul").append(li);
    }
}

/*
 * funzione che abilita la modifica dei dati di un elemento
 */
function abilitaModificaDati(){
    ID_Product= giveID($(this).attr('id'));
    console.log(ID_Product);

    $("#"+ID_Product+"_modifyBTN").css('display', "none");
    $("#"+ID_Product+"_sendmodBTN").css('display', "initial");

    $("#"+ID_Product+"_Name").attr('readonly', false);
    $("#"+ID_Product+"_Desc").attr('readonly', false); 
    $("#"+ID_Product+"_Qty").attr('readonly', false); 
    $("#"+ID_Product+"_Price").attr('readonly', false);  
    $("#"+ID_Product+"_Discount").attr('readonly', false); 
}

/*
 * funzione che modifica i dati di un elemento
 * (richiede al server la modifica dei dati)
 */
function modProduct(){
    ID_Product= giveID($(this).attr('id'));

    var DataStr= "" +
        "ID_Product=" + ID_Product +
        "&Name=" + $("#"+ID_Product+"_Name").val() +
        "&Desc=" + $("#"+ID_Product+"_Desc").val() +
        "&Qty=" + $("#"+ID_Product+"_Qty").val() +
        "&Price=" + $("#"+ID_Product+"_Price").val() +
        "&Discount=" + $("#"+ID_Product+"_Discount").val();
    $.ajax({
        url: "../php/modifyProduct.php",
        type: "POST",
        data: DataStr,
        datatype: "json",
        success: function(json){
            if(JSON.parse(json).result == "TRUE") showProduct();
            else $(".ErrorSTR").text(JSON.parse(json).StrErr);
        },
        error: function(){$(".ErrorSTR").html("Modifica non valida");}
    });
}

/*
 * funzione che rimuove un elemento dalla lista
 * (richiede al server la rimozione dalla lista)
 */
function removeProduct() {
    $.ajax({
        url: "../php/removeProduct.php",
        type: "POST",
        data: "ID_Product=" + giveID($(this).attr('id')),
        datatype: "json",
        success: function(json){
            if(JSON.parse(json).result == "TRUE") showProduct();
            else $(".ErrorSTR").text(JSON.parse(json).StrErr);
        },
        error: function(){$(".ErrorSTR").html("Rimozione non valida");}
    });
}

/*
 * funzione che ottiene l'id di un product da l'id di un <li> element
 * str : id di un <li> element
 */
function giveID(str){
    return parseInt(str.split("_")[0]);
}