/*
    @autor: Giorgio Mecca
    Matricola : 880847
*/
$(function(){
    showProduct();

    $("#order").click(order);
}); 

/*
 * funzione che effettua l'ordine degli elementi nel carrello
 * seguendo la quantita' indicata
 */ 
function order(){
    var dataStr=""; 
    elements=$('#body-block ul li');
    for(var i=0; i< $('#body-block ul li').length; i++){
        element= elements[i];
        if (i>=1) dataStr+= "&";
        var idLI= $(element).attr('id');
        dataStr += idLI+ "=" + $("#body-block ul #"+idLI+" select[name=qty] option:selected").text();
    }

    $.ajax({
        url: "../php/function/order.php",
        type: "GET",
        data: dataStr,
        datatype: "json",
        success: function(json){
            if(JSON.parse(json).result == "TRUE"){
                location.href= "../php/ordersList.php";
            }else{
                $(".ErrorSTR").text(JSON.parse(json).StrErr);
            }
        },
        error: function(){$(".ErrorSTR").text("Error\n Server Offline");},
    });
    
}

/*
 * funzione che richiede al server la lista dei prodotti nel carrello
 */
function showProduct(){
    $.ajax({
        url: "../php/function/cart.php",
        type: "GET",
        datatype: "json",
        success: showCartProduct,
        error: function(){$(".ErrorSTR").html("Errore Momentaneo, \n Riprovare in seguito");}
    });
}

/*
* crea e imposta gli elem(<li>) di una lista
* json: lista di oggetti da mostrare
*/ 
function showCartProduct(json){
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


            var select = $('<select></select>');    select.attr('name', 'qty');
                for(var j=0; j<element.Qty; j++){
                    var op= $('<option></option>'); 
                    op.html(j+1);
                    select.append(op);
                }
            div11.append(select);
            
            var btnR = $('<button></button>');
            btnR.html("Rimuovi");
            btnR.click(function(){
                $.ajax({
                    url: "../php/function/removeElement.php",
                    type: "GET",
                    data: "From="+ "Cart" + "&ID_Product=" + $(this).parent().parent().attr('id'),
                    datatype: "json",
                    success: function(json){
                        if(JSON.parse(json).result == "TRUE") showProduct();
                        else $(".ErrorSTR").html(JSON.parse(json).StrErr);
                    },
                    error: function(){$(".ErrorSTR").html("Errore Momentaneo, \n Riprovare in seguito");}
                });
            });
            
            div11.append(btnR);
            
        li.append(div11);


        $("#body-block ul").append(li);
    }
}