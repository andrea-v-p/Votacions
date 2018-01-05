
//ANIMACION DE LAS VOTACIONES
function efecto(){
	var respuestas = document.getElementsByClassName("formu");
	 for (var i = 0; i < respuestas.length ; i++) {
	 	var respuesta = document.getElementById("vota"+i);
	 	
	 	animacion(respuesta);
	 }
}

function animacion(elemento) { 
  var pos = -700;
  var id = setInterval(frame, 15);
  function frame() {
    if (pos == 250) {
      clearInterval(id);
    } else {
      pos=pos+5;  
      console.log(elemento); 
      elemento.style.left = pos + 'px'; 
    }
  }
}

