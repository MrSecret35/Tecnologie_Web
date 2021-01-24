/*
    @autor: Giorgio Mecca
    Matricola : 880847
*/
$(function(){

    document.getElementById("Registration").style.display = "none";

    $("#p_registration_btn").click(setRegistration); //Button per abilitare la registrazione

    $("#LoginBTN").click(LoginBTN); //Button per il Login

    $("#RegistrationBTN").click(RegistrationBTN); //Button per la registrazione

});

/*
 * funzione che effettua (se possibile) il login 
 */
function LoginBTN(){
    var email = $("#mail_login").val();
    var psw = $("#psw_login").val();
        
    $(".ErrorSTR").text("");

    if(email.length!=0 && psw.length!=0 ){
    if(verifymailtype(email)){
        $.ajax({
            url: "../php/function/login.php",
            type: "POST",
            data : 'EMail=' + email + '&Psw=' + psw ,
            datatype: "json",
            success: function(json){
                if(JSON.parse(json).result == "TRUE"){
                    location.href= "../php/index.php";
                }else{
                    $(".ErrorSTR").text(JSON.parse(json).StrErr);
                }
            },
            error: function(){$(".ErrorSTR").text("Error\n Server Offline");},        
        });
    }else $(".ErrorSTR").text("Mail non Valida");
    }else $(".ErrorSTR").text("Campi vuoti!!!");
}

/*
 * funzione che effettua (se possibile) la registrazione 
 */
function RegistrationBTN(){
    
    var email = $("#mail_reg").val();
    var psw = $("#psw_reg").val();
    var psw1 = $("#psw1_reg").val();  
    $(".ErrorSTR").text("");

    if(email.length!=0 && psw.length!=0){
    if(psw==psw1){
    if(verifymailtype(email)){
        var StrData="";
        if($("input[type=radio][name=BTNReg]:checked").val() == "User"){//registrazione come utente
            StrData += "Type=" + "User";
            StrData +='&EMail=' + email + '&Psw=' + psw ;
            if($("#name_u_reg").val().length!=0) StrData += "&Name=" + $("#name_u_reg").val();
            if($("#surname_u_reg").val().length!=0) StrData += "&Surname=" + $("#surname_u_reg").val();
        }else{//registrazione come azienda
            StrData += "Type=" + "Business";
            StrData +='&EMail=' + email + '&Psw=' + psw ;
            if($("#name_b_reg").val().length!=0) StrData += "&Name=" + $("#name_b_reg").val();
            if($("#desc_b_reg").val().length!=0) StrData += "&Desc=" + $("#desc_b_reg").val();
            if($("#link_b_reg").val().length!=0) StrData += "&Link=" + $("#link_b_reg").val();
            if($("#tel_b_reg").val().length!=0) StrData += "&Tel=" + $("#tel_b_reg").val();
        }
        $.ajax({
            url: "../php/function/registration.php",
            type: "POST",
            data : StrData,
            datatype: "json",
            success: function(json){   
                if(JSON.parse(json).result == "TRUE"){
                    location.href= "../php/index.php";
                }else{
                    $(".ErrorSTR").text(JSON.parse(json).StrErr);
                }
            },
            error: function(){$(".ErrorSTR").text("Error\n Server Offline");},         
        });
    }else $(".ErrorSTR").text("Mail non Valida");
    }else $(".ErrorSTR").text("Le Password non corrispondono");
    }else $(".ErrorSTR").text("I campi mail e password sono obbligatori");
}

/*
 * funzione che abilita (rende possibile) la registrazione 
 */
function setRegistration(){
    $(".ErrorSTR").text("");

    $("#Login").css("display", "none");
    $("#Registration").css("display","initial" );

    //$("#User").css("display", "none");
    $("#Business").css("display", "none");
    //$("#RegistrationBTN").css("display", "none");

    $("#BTNUser").click(setRegistration_User);
    $("#BTNBusiness").click(setRegistration_Business);
}

/*
 * funzione che abilita (rende possibile) la registrazione come utente
 */
function setRegistration_User(){
    $("#User").css("display", "initial");
    $("#Business").css("display", "none");
    $("#RegistrationBTN").css("display", "initial");
}

/*
 * funzione che abilita (rende possibile) la registrazione come azienda
 */
function setRegistration_Business(){
    $("#User").css("display", "none");
    $("#Business").css("display", "initial");
    $("#RegistrationBTN").css("display", "initial");
}

/*
 * funzione che verifica se una stringa può eddere una mail
 * str: stringa da controllare
 */
function verifymailtype(str){
    return str.indexOf('@') != -1 && str.indexOf('.',str.indexOf('@'))!= -1;
}
