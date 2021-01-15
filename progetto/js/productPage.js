var ID_Product = new URL(window.location.href).searchParams.get("ID_Product");

$(function(){
    SetDataProduct();

    $("#buttonDiv #cart").click(addElementCart);
    $("#buttonDiv #list").click(addElementList);
});

function SetDataProduct(){

    $.ajax({
        url: "../php/search.php",
        type: "GET",
        data: "ID_Product=" + ID_Product,
        datatype: "json",
        success: WriteDataProduct,
    });

}

function WriteDataProduct(json){

    var data= JSON.parse(json);

    
    if(data.length >= 1){
        element= data[0];


        if (element.Img != null) $("#imgDiv img").attr("src", "data:image/  png;base64," + element.Img);
        else $("#imgDiv img").attr("src", "../img/img.png");

        if(element.Name.length != 0) $("#ProductData #Name").html(element.Name);
        if(element.Description.length != 0) $("#ProductData #Desc").html(element.Description);

        if(element.Discount == null || parseInt(element.Discount)==0) $("#ProductData #Price").html(element.Price + ' €' );
        else {
            var newPrice = parseInt(element.Price) - ((parseInt(element.Price)*parseInt(element.Discount))/100);
            $("#ProductData #Price").html('<del>' + element.Price + ' €</del>   ' + newPrice + ' €');
        }
        $("#ProductData #Qty").html("Disponibilità:  " + element.Qty);

        $.ajax({
            url: "../php/seller.php" ,
            type: "GET",
            data: "ID_Seller=" + element.ID_Seller,
            datatype: "json",
            success: WriteDataSeller,
        });

        
    }
    
}

function WriteDataSeller(json){
    $("#SellerData ul").empty();
    var data = JSON.parse(json);
    for(var i=0; i<data.length ;i++){
        Object.values(data[i]).forEach(element => {
            if(element!= null){
                var li = $('<li></li>');
                li.html(element);
                $("#SellerData ul").append(li);
            }
            
       });
    }
}

function addElementCart(){
    var qty= $("#ProductData #Qty").html().split(':')[1];
    qty= parseInt(qty);
    if(qty> 0){
        $.ajax({
            url: "../php/addElement.php",
            type: "GET",
            data: "To=" + "Cart" + "&ID_Product=" + ID_Product,
            datatype: "json",
            success: function(json){
                if(JSON.parse(json).result == "TRUE"){
                    location.href= "../php/shoppingCart.php";
                }else{
                    $(".ErrorSTR").text(JSON.parse(json).StrErr);
                }
            },
            error: function(){$(".ErrorSTR").text("Error\n Server Offline");},
        });
    }else {
        $(".ErrorSTR").text("Prodotto non disponibile" );
        $("#ProductData #Qty").css("color", "red");
    }
}

function addElementList(){
    $.ajax({
        url: "../php/addElement.php",
        type: "GET",
        data: "To=" + "List" + "&ID_Product=" + ID_Product,
        datatype: "json",
        success: function(json){
            if(JSON.parse(json).result == "TRUE"){
                location.href= "../php/favoritesList.php";
            }else{
                $(".ErrorSTR").text(JSON.parse(json).StrErr);
            }
        },
        error: function(){$(".ErrorSTR").text("Error\n Server Offline");},
    });
}
