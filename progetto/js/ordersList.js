/*
    @autor: Giorgio Mecca
    Matricola : 880847
*/
$(function(){
    showProduct();

    $("#homeBTN").click(function(){  location.href= "../php/index.php";});
    $("#myBTN").click(function(){  location.href= "../php/profile.php";});
}); 

/*
 * funzione che richiede al server la lista dei prodotti ordinati
 */
function showProduct(){
    $.ajax({
        url: "../php/function/orders.php",
        type: "GET",
        datatype: "json",
        success: showOrderProduct,
    });
}

/*
* crea e imposta gli elem(<li>) di una lista
* json: lista di oggetti da mostrare
*/ 
function showOrderProduct(json){
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

                div2.html(element.Name  + '<br>' + "Data Ordine:   " + element.DataOrder + '<br>' + "Quantità:   " + element.Qty);

            span.append(div1);
            span.append(div2);

            a.append(span);

        li.append(a);


        $("#body-block ul").append(li);
    }
}