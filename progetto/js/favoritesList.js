$(function(){
    showProduct();

    $("#homeBTN").click(function(){  location.href= "../php/index.php";});
    $("#myBTN").click(function(){  location.href= "../php/profile.php";});
}); 

/*
 * funzione che effettua la richiesta della lista dei preferiti al server(ajax)
 */
function showProduct(){
    $.ajax({
        url: "../php/function/favorites.php",
        type: "GET",
        datatype: "json",
        success: showListProduct,
        error: function(){$(".ErrorSTR").html("Errore Momentaneo, \n Riprovare in seguito");}
    });
}

/*
 * mostra(crea gli elementi <li> ed i stotto elementi) la lista dei preferiti
  * json: argomento che indica i dati (lista di oggetti) da stampare
 */
function showListProduct(json){
    var data= JSON.parse(json);
    $("#body-block ul").empty();

    for(i= 0; i< data.length; i++){
        var element= data[i];

        var li= $('<li></li>');     li.attr('id', element.ID_Product);

        var a = $('<a></a>')
        a.attr("href", "../php/productPage.php?ID_Product="+element.ID_Product);

            var span = $('<span></span>');

                var div1 = $('<div></div>');    div1.attr('id', 'div_img_product');
                
                    var img = $('<img></img>')
                    if (element.Img != null) img.attr("src", "data:image/  png;base64," + element.Img);
                    else img.attr("src", "../img/img.png");
                div1.append(img);

                var div2 = $('<div></div>');    div2.attr('id', 'div_Str_product');

                    if(element.Discount == null || parseInt(element.Discount)==0) div2.html(element.Name  + '<br>' + element.Price + ' €' );
                    else {
                        var newPrice = parseInt(element.Price) - ((parseInt(element.Price)*parseInt(element.Discount))/100);
                        div2.html(element.Name  + '<br> <del>' + element.Price + ' €</del>   ' + newPrice + ' €');
                    }

            span.append(div1);
            span.append(div2);

            a.append(span);

        li.append(a);
        
            var div11 = $('<div></div>');    div11.attr('id', 'div_choise_product');

            
            var btnR = $('<button></button>'); btnR.attr('id', 'remove');
            btnR.html("Rimuovi dalla Lista");
            btnR.click(function(){
                $.ajax({
                    url: "../php/function/removeElement.php",
                    type: "GET",
                    data: "From="+ "List" + "&ID_Product=" + element.ID_Product,
                    datatype: "json",
                    success: function(json){
                        if(JSON.parse(json).result == "TRUE") showProduct();
                        else $(".ErrorSTR").html(JSON.parse(json).StrErr);
                    },
                    error: function(){$(".ErrorSTR").html("Errore Momentaneo, \n Riprovare in seguito");}
                });
            });

            var btnC = $('<button></button>'); btnC.attr('id', 'cart');
            btnC.html("Sposta nel carrello");
            btnC.click(function(){
                $.ajax({
                    url: "../php/function/addElement.php",
                    type: "GET",
                    data: "To="+ "Cart" + "&ID_Product=" + element.ID_Product,
                    datatype: "json",
                    success: function(json){
                        if(JSON.parse(json).result == "TRUE") {
                            $.ajax({
                                url: "../php/function/removeElement.php",
                                type: "GET",
                                data: "From="+ "List" + "&ID_Product=" + element.ID_Product,
                                datatype: "json",
                                success: function(json){
                                    if(JSON.parse(json).result == "TRUE") showProduct();
                                    else $(".ErrorSTR").html(JSON.parse(json).StrErr);
                                },
                                error: function(){$(".ErrorSTR").html("Errore Momentaneo, \n Riprovare in seguito");}
                            });
                        }
                        else $(".ErrorSTR").html(JSON.parse(json).StrErr);
                    },
                    error: function(){$(".ErrorSTR").html("Errore Momentaneo, \n Riprovare in seguito");}
                });
            });
            
            div11.append(btnR);
            div11.append(btnC);

        li.append(div11);


        $("#body-block ul").append(li);
    }
}