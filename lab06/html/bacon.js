
$(function(){
    $("#results").hide();
    $("#searchall").find('[name="submit"]').click(function(){
        var fs= $("#searchall").find('[name="firstname"]').val();
        var ls= $("#searchall").find('[name="lastname"]').val();
        if(fs && ls){
            $.ajax({
                url: "getMovieList.php?firstname=" + fs + "&lastname=" + ls + "&all=true",
                type: "GET",
                datatype: "json",
                success: showFilm,
                error: ajaxFailed     
                }
            );
        }
    });

    $("#searchkevin").find('[name="submit"]').click(function(){
        var fs= $("#searchkevin").find('[name="firstname"]').val();
        var ls= $("#searchkevin").find('[name="lastname"]').val();
        if(fs && ls){
            $.ajax({
                url: "getMovieList.php?firstname=" + fs + "&lastname=" + ls ,
                type: "GET",
                datatype: "json",
                success: showFilm,
                error: ajaxFailed     
                }
            );
        }
    });


});

function showFilm(json){
    $("#results").show();
    $("#results").find('table').show();
    
    
    var data = JSON.parse(json); 
    
    $("#firstN").html(data.name.firstname);
    $("#lastN").html(data.name.lastname);

    $("#list").find('tr').nextAll().remove();
    if(data.film.length == 0){
        $("#results").find('h1').html("Nothing to Show");
        $("#results").find('table').hide();
    }
    data.film.forEach(function(item){
        var tr = $('<tr></tr>');
        //li.html(item.title + ", by " + item.author + " (" + item.year + ")");
        var td1 = $('<td></td>');var td2 = $('<td></td>');var td3 = $('<td></td>');
        td1.html(item.number); td2.html(item.title); td3.html(item.year); 
        tr.append(td1);tr.append(td2);tr.append(td3);
        $("#list").append(tr);
    });
}

function ajaxFailed(e) {
	var errorMessage = "Error making Ajax request:\n\n";
		
	errorMessage += "Server status:\n" + e.status + " " + e.statusText + 
		                "\n\nServer response text:\n" + e.responseText;
    alert(errorMessage);
}
