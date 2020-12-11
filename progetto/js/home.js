$(function(){
    $("#search_icon").click(search);

});

function search(){
    var str = $("#search_bar").val();
    if(str.length != 0){
        $.ajax({
            url: "../php/search.php?Str_Product=" + str,
            type: "GET",
            datatype: "json",
            success: showResultSearch,
            error: ajaxFailed 
        });
    }
}

function showResultSearch(json){
    
    var data= JSON.parse(json);
    
    //$("#products").empty();
    /*
    var ul= $('<ul></ul>');
    ul.attr("id", "ul_products")
    $("#products").append(ul);
    */
    showTenResult(json,1);

    //createPage(json)
    //showFourPage(1) riferimento alla prima pagina
    /*deve settare tutti ad Hide e mostrare solo 4 cose*/
    var numPage = parseInt(data.length)/10;
    for(var j=0; j<= numPage; j++){
        var li = $('<li></li>');
        li.html(j+1);
        
        var h= parseInt(j)+1;
        var id= "page_products_"+h;
        //var id= makeIdPage(j+1);
        li.attr("id", id)
        li.click(function(){
            var num= parseInt($(this).attr('id').charAt(14));
            showTenResult(json,num);
        });
        $("#page_products").find("ul").append(li);
    }
}

function showTenResult(json,num){
    console.log(JSON.parse(json));
    
    var data= JSON.parse(json);

    $("#ul_products").empty();

    for(i= ((num-1)*10); i< data.length && i< (num*10)-1; i++){
        var element= data[i];

        var li= $('<li></li>');
        li.addClass("li_product");

            var span = $('<span></span>');
            span.addClass("span_product");

                var div1 = $('<div></div>');
                div1.addClass("div_img_product");
                    var img = $('<img></img>')
                    img.addClass("img_product");
                    img.attr("src", "../img/img.png");//attenzione qui devi mettere l'immagine del db
                div1.append(img);
                var div2 = $('<div></div>');
                div2.addClass("div_Str_product");
                if(element.Discount == null || parseInt(element.Discount)==0) div2.html(element.Name  + '<br>' + element.Price + ' €' );
                else {
                    var newPrice = parseInt(element.Price) - ((parseInt(element.Price)*parseInt(element.Discount))/100);
                    div2.html(element.Name  + '<br> <del>' + element.Price + ' €</del>   ' + newPrice + ' €');
                }

            span.append(div1);
            span.append(div2);
        li.append(span);
        $("#ul_products").append(li);
    }
}

function ajaxFailed(e) {
	var errorMessage = "Error making Ajax request:\n\n";
	errorMessage += "Server status:\n" + e.status + " " + e.statusText + 
		                "\n\nServer response text:\n" + e.responseText;
    alert(errorMessage);
}