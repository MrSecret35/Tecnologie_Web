NUM_ELEM_PAG= 3;

$(function(){
    $("#search_icon").click(search);

    $(document).keypress(function(e) { 
        if(e.which == 13) { 
            search();
        } 
    });

    setCategories();

    allProduct();
});

function search(){
    var str = $("#search_bar").val();
    if(str.length != 0){
        $.ajax({
            url: "../php/search.php?Str_Product=" + str,
            type: "GET",
            datatype: "json",
            success: showResultSearch,
        });
    }
}

function allProduct(){
    $.ajax({
        url: "../php/product.php",
        type: "GET",
        datatype: "json",
        success: showResultSearch,
    });
}
/*
* crea e mostra i primi NUM_ELEM_PAG prodotti e le prime 4 pagine
*/ 
function showResultSearch(json){
    
    showNResult(json,1);//mostro i primi NUM_ELEM_PAG result

    createPage(json);
    showFourPage(1); //mostro le prime 4 pagine
    if(JSON.parse(json).length == 0){
        $("#notification").html("La tua ricerca non ha prodotto risultati");
    }
    
    
}

/*
* crea gli elem lista dei NUM_ELEM_PAG prodotti da mostrare 
*/ 
function showNResult(json,num){
    
    var data= JSON.parse(json);

    $("#ul_products").empty();
    for(i= ((num-1)*NUM_ELEM_PAG); i< data.length && i< (num*NUM_ELEM_PAG); i++){
        
        var element= data[i];

        

        var li= $('<li></li>');
        li.addClass("li_product");
        var a = $('<a></a>')
        a.attr("href", "../php/productPage.php?ID_Product="+element.ID);

            var span = $('<span></span>');
            span.addClass("span_product");

                var div1 = $('<div></div>');
                div1.addClass("div_img_product");
                    var img = $('<img></img>')
                    img.addClass("img_product");
                    if (element.Img != null) img.attr("src", "data:image/  png;base64," + element.Img);
                    else img.attr("src", "../img/img.png");
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
        a.append(span);

        li.append(a);
        $("#ul_products").append(li);
        //a.append(li);
        //$("#ul_products").append(a);
    }
}

/*
* crea gli elementi lista che indicheranno le pagine 
*/ 
function createPage(json){
    var data= JSON.parse(json);

    $("#page_products ul").empty();

    var numPage = parseInt(data.length)/NUM_ELEM_PAG;
    for(var j=0; j< numPage && data.length!=0 ; j++){
        var li = $('<li></li>');
        li.html(j+1);
        
        
        var id= makeIdPage(j+1);
        li.attr("id", id)

        li.click(function (){
            var num= parseInt($(this).attr("id").charAt(14));
            showNResult(json,num);
            showFourPage(num);
        });
        
        $("#page_products").find("ul").append(li);
    }
}

/*
 *crea un ID per un <li> di una pagina a partire dal numero della pagina
 * i: numero della pagina
*/
function makeIdPage(j){
    var h= parseInt(j);
    var id= "page_products_"+h;
    return id;
}

/*
 *funzione che rende visibile solo 4 pagine da num-1 a num+2
 * num: numero pagina attualmente selezionata 
*/
function showFourPage(num){
    for(var i=0; i< $("#page_products ul li").length; i++){
        if(i>=num-1 || i<= num+2) $(makeIdPage(i)).css("display", "none");
        else $(makeIdPage(i)).css("display","initial" );
    }
}

function setCategories(){
    $("#categories").empty();
    $.ajax({
        url: "../php/categories.php",
        datatype: "json",
        success: showCategories,
    });
}

function showCategories(json){
    var data= JSON.parse(json);
    data.forEach(elem => {
        var li = $('<li></li>');
        var cat= elem.Category;
        li.html(cat);
        li.click(function(){
                $.ajax({
                url: "../php/search.php?Str_Product=" + cat,
                type: "GET",
                datatype: "json",
                success: showResultSearch,
                })
            }
        );

        $("#categories").append(li);
    });
}
