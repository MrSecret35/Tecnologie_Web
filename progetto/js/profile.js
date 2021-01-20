$(function(){

    setPersonalData();

    listAddress();

    $("#divNewAddress").css("display", "none");

    $("#newAddress").click(newaddress);
});

/*
 * funzione che richiede al server i dati dell'utente
 */
function setPersonalData(){
    $.ajax({
        url: "../php/personalData.php",
        type: "GET",
        data : "",
        datatype: "json",
        success: function(json){   
            var data= JSON.parse(json);
            if(data.Type == "User"){
                $("#UserInfo").find("#Mail").html(data.Data.EMail);
                $("#UserInfo").find("#Name").html(data.Data.Name ? data.Data.Name : "//");
                $("#UserInfo").find("#Surname").html(data.Data.Surname ? data.Data.Surname : "//");
            }else{
                $("#UserInfo").find("#Mail").html(data.Data.EMail);
                $("#UserInfo").find("#Name").html(data.Data.Name ? data.Data.Name: "//");
                $("#UserInfo").find("#Link").html(data.Data.Link ? data.Data.Link : "//");
                $("#UserInfo").find("#NTel").html(data.Data.PhoneN ? data.Data.PhoneN : "//");
            }
        },        
    });
}

/*
 * funzione che richiede al server gli indirizzi dell'utente
 */
function listAddress(){
    $.ajax({
        url: "../php/addresses.php",
        type: "GET",
        datatype: "json",
        success: function(json){  
            if(JSON.parse(json).length >= 1){
                showAddress(json);

            }else{
                $("#AddressStr").html("Non hai inserito Indirizzi");
            }
        },
    });
}

/*
 * funzione che mostra gli indirizzi dell'utente
 * json: lista di oggetti(indirizzi) da mostrare
 */
function showAddress(json){
    JSON.parse(json).forEach(element => {
        var div = $('<div></div>');
        div.addClass("Address");

        var ul = $('<ul></ul>');

        var li1 = $('<li></li>');
        li1.html(element.State);
        var li2 = $('<li></li>');
        li2.html(element.City);
        var li3 = $('<li></li>');
        li3.html(element.Street);
        var li4 = $('<li></li>');
        li4.html(element.StreetN);

        ul.append(li1);
        ul.append(li2);
        ul.append(li3);
        ul.append(li4);

        div.append(ul);

        $("#Addresses").find('h1').first().after(div);

    });
}

/*
 * funzione che abilita l'aggiunta di un nuovo indirizzo
 */
function newaddress(){
    $("#newAddress").css("display", "none");
    $("#divNewAddress").css("display", "inherit");
    $("#addNewAddress").click(addNewAddress);
}

/*
 * funzione che aggiunge un nuovo indirizzo
 */
function addNewAddress(){
    
    if(    $("#State").val().length!=0
        && $("#City").val().length!=0
        && $("#Street").val().length!=0
        && $("#StreetN").val().length!=0){

        var StrData = "State=" + $("#State").val()
                            + "&City=" + $("#City").val()
                            + "&Street=" + $("#Street").val()
                            + "&StreetN=" + $("#StreetN").val()
        
        $.ajax({
            url: "../php/addAddress.php",
            type: "GET",
            data : StrData,
            datatype: "json",
            success: function(json){  
                if(JSON.parse(json).result == "TRUE"){
                    
                    $("#newAddress").css("display", "inherit");
                    $("#divNewAddress").css("display", "none");
                    $("#divNewAddress").find("input").array.forEach(element => {
                        element.val("");
                    }); 
                    listAddress();
                }else{
                    $(".ErrorSTR").text(JSON.parse(json).StrErr);
                }
            },        
        });
    }else{
        $(".ErrorSTR").text("Campo Mancante");
    }
}
