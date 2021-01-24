/*
    @autor: Giorgio Mecca
    Matricola : 880847
*/
$(function(){
    setCategories();

    $("#newProductBTN").click(newProduct);
});

/*
 * funzione che richiede al server le categorie possibili
 */
function setCategories(){
    $("#category").empty();
    $.ajax({
        url: "../php/function/categories.php",
        datatype: "json",
        success: showCategories,
    });
}

/*
 * funzione che mostra le categorie da scegliere
 * json: lista di categorie
 */
function showCategories(json){
    var data= JSON.parse(json);
    data.forEach(elem => {
        var option = $('<option></option>');
        var cat= elem.Category;
        option.html(cat);
        $("#category").append(option);
    });
}

/*
 * funzione che aggiunge un nuovo prodotto
 */
function newProduct(){
    var data= new Array();
    data['name'] = $("#sell_div #name").val();
    data['desc'] = $("#sell_div #desc").val();
    data['qty'] = $("#sell_div #qty").val();
    data['cat'] = $("#sell_div #category").val();
    data['price'] = $("#sell_div #price").val();
    

    var strData= "Name=" + data['name']
                    + "&Desc=" + data['desc']
                    + "&Qty=" + data['qty']
                    + "&Cat=" + data['cat']
                    + "&Price=" + data['price'];

    var Form_Data = new FormData();
    if($("#sell_div #img").val().length != 0) Form_Data.append("img", $("#sell_div #img").prop('files')[0]);
    
    if(controllaDati(data)){
        $.ajax({
            url: "../php/function/insertProduct.php?"+strData,
            type: "POST",
            data: Form_Data,
            contentType:false,
            cache:false,
            processData:false,
            datatype: "json",
            success: function(json){
                if(JSON.parse(json).resuls != "FALSE"){
                    location.href= "../php/index.php";
                }else{
                    $("#ErrorStrIns").html(JSON.parse(json).StrErr);
                }
                
            },
            error: function(){$(".ErrorStrIns").text("Error\n Server Offline");},
        });
    }
    

}

/*
 * funzione che controlla i dati del "nuovo" prodotto
 */
function controllaDati(data){
    if(data['name'].length >= 1)
    if(data['desc'].length >= 1) 
    if(data['qty'].length >= 1)
    if(data['price'].length >= 1)
        return true;
    else $("#ErrorStrPrice").html("*Campo Prezzo Vuoto");
    else $("#ErrorStrQty").html("*Campo Quantita' Vuoto");
    else $("#ErrorStrDesc").html("*Campo Descrizione Vuoto");
    else $("#ErrorStrName").html("*Campo Nome Vuoto");
    
    return false;
}