var blocchi = new Array();
var posBlank= new Array();
var DIM=100;

window.onload= function(){

	inizializeBlock();

	document.getElementById("shufflebutton").onclick= shuffle;
}


function inizializeBlock(){

	var panel = document.getElementById("puzzlearea");
	//creo e setto il div vuoto
	/*
	var ultimateDiv = document.createElement("div");
	ultimateDiv.innerHTML="b"; // b for blank
	ultimateDiv.classList.add("div-game-blank");
	panel.appendChild(ultimateDiv);
	posBlank=15;
	*/
	//inizializzo la var globale blocchi come arry contenente i children di puzzlearea
	posBlank["x"]=3;
	posBlank["y"]=3;

	//effettuo il set dei valori dei div da 1 a 15
	var c=0;
	for (var i = 0; i < 4; i++) {
		for (var j = 0; j < 4 && !(i==3 && j==3); j++) {
			blocchi[makeID(i,j)] = panel.children[c];
			var elem = blocchi[makeID(i,j)];
			elem.id= makeID(i,j);
			elem.classList.add("div-game");
			elem.style.backgroundImage = "url('background.jpg')";
			elem.style.backgroundPosition = "-" + (j*DIM) + "px -" + (i*DIM) + "px";
			elem.style.top  = (i*DIM) + "px";
			elem.style.left = (j*DIM) + "px";

			elem.onmouseover = mouseON;
			elem.onmouseout  = mouseOUT;

 			elem.onclick   = move;
			c++;
		}
	}
}
function makeID(a,b){
	return "tile_" + a + "_" +b;
}
function undoID(str){
	var b=new Array();
	b[0]= str.charAt(5);
	b[1]= str.charAt(7);
	return b;
}


function shuffle(){//mescola i vari blocchi 
	for(var i= 0; i<  Math.floor(Math.random() * 20) + 20; i++){
		var posizioni = new Array();var c=0;
		if(posBlank["y"] >= 1){//posso andare a sinistra?
			posizioni[c]=makeID(posBlank["x"],parseInt(posBlank["y"]) - 1);c++;
		}
		if(posBlank["x"] <= 2){//posso andare a sotto?
			posizioni[c]=makeID(parseInt(posBlank["x"]) + 1,posBlank["y"]);c++;
		}
		if(posBlank["y"] <= 2){//posso andare a destra?
			posizioni[c]=makeID(posBlank["x"],parseInt(posBlank["y"]) + 1);c++;
		}
		if(posBlank["x"] >= 1){//posso andare a sopra?
			posizioni[c]=makeID(parseInt(posBlank["x"]) - 1,posBlank["y"]);c++;
		}

		var j = Math.floor(Math.random() * c);

		swapElementsBlank(posizioni[j]);
		
		
	}
}

function swapElementsBlank(newID){//scambio l'elemento del newID con il blocco vuoto
	var elem = blocchi[newID];
	
	elem.style.top  = (posBlank["x"]*DIM) + "px";
	elem.style.left = (posBlank["y"]*DIM) + "px";
	elem.id = makeID(posBlank["x"],posBlank["y"]);
	blocchi[makeID(posBlank["x"],posBlank["y"])]= elem;

	posBlank["x"] = undoID(newID)[0];
	posBlank["y"] = undoID(newID)[1];
}

function mouseON(){
	if(canMove(this.id)){
		this.classList.add("div-game-m");
		
	}
}
function mouseOUT(){
	this.classList.remove("div-game-m");
}

function canMove(id){
	var b = undoID(id);
	if((b[0] - parseInt(posBlank["x"])) == -1 || (b[0] - parseInt(posBlank["x"])) == 1)
		if(b[1]==parseInt(posBlank["y"]))
			return true;
	
	if((b[1] - parseInt(posBlank["y"])) == -1 || (b[1] - parseInt(posBlank["y"])) == 1)
		if(b[0]==parseInt(posBlank["x"]))
			return true;

	return false;
}

function move(){ 
	if(canMove(this.id)){
		swapElementsBlank(this.id);

		if(controllo()){
			console.log("vittoriaa");
		}
	}
	
}

function controllo(){
	if(posBlank["x"] != 3 || posBlank["y"] != 3) return false;
	for (var i = 0; i < 4; i++) {
		for (var j = 0; j < 4 && !(i==3 && j==3); j++) {
			var top= (i*DIM) + "px"; var left=(j*DIM) + "px";
			var elem = blocchi[makeID(i,j)];
			if(elem.style.top != top || elem.style.left != left){
				return false;
			}
			
		}
	}
	return true;
}
