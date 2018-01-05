//Variable global que cuenta cuantas respuestas (inputs) hay
var cantidadRespuestas = 1;

//Variables globales para la fecha actual
var hoy = new Date();
var dia = hoy.getDate();
var mes = hoy.getMonth()+1;
var ano = hoy.getFullYear();

function crearConsulta(){

	//recogemos los labels, el textarea y los inputs y los guardamos en variables
	var label = document.getElementsByTagName("label");
	var pregunta = document.getElementsByTagName("textarea");
	var respuesta = document.getElementsByTagName("input");
	
	//hacemos que sean visibles los labels
	for(var i=0;i<label.length;i++){
		mostrar(label[i]);
	}
	
	//hacemos que sean visibles las preguntas
	for(var i=0;i<pregunta.length;i++){
		mostrar(pregunta[i]);
	}

	//hacemos que sean visibles las respuestas
	for(var i=0;i<respuesta.length;i++){
		mostrar(respuesta[i]);
	}
	
	//creamos los siguientes botones
	crearBotonRespuestas();
	crearBotonEliminar();
	crearBotonEnviar();
	
	//creamos los inputs y labels para las fechas
	crearFechaInicio();
	crearFechaFinal();
	
	//añadimos dos respuestas como mínimo obligatoriamente
	añadirElemento(crearLabel(),crearInput());
	añadirElemento(crearLabel(),crearInput());
	
	document.querySelector("input[name='fechaFinal']").disabled = true;	
	document.querySelector("input[name='horaInicio']").disabled = true;
	document.querySelector("input[name='horaFinal']").disabled = true;
	
	
}

//la siguiente funcion crea el boton Crear Respuestas
function crearBotonRespuestas(){
	//creamos el elemento y lo guardamos en una variable
	var boton = document.createElement("BUTTON");
	//creamos texto para ese boton
	var texto = document.createTextNode("Crear Respuestas");
	//añadimos el texto anterior al boton
	boton.appendChild(texto);
	//le añadimos al boton el atributo onClick
	boton.setAttribute("onclick","crearRespuesta()");
	//añadimos el boton a su html para que sea visible
	var padre = document.getElementById("botones");
	padre.insertBefore(boton,padre.firstChild);
}

//la siguiente funcion crea el boton Eliminar Respuestas
function crearBotonEliminar(){
	//creamos el elemento y lo guardamos en una variable
	var boton = document.createElement("BUTTON");
	//creamos texto para ese boton
	var texto = document.createTextNode("Eliminar respuestas");
	//añadimos el texto anterior al boton
	boton.appendChild(texto);
	//le añadimos al boton el atributo onClick
	boton.setAttribute("onclick","eliminarRespuestas()");
	//añadimos el boton a su html para que sea visible
	var padre = document.getElementById("botones");
	padre.insertBefore(boton,padre.firstChild);
}

//la siguiente funcion crea el boton Enviar Datos
function crearBotonEnviar(){
	//creamos el elemento y lo guardamos en una variable
	var boton = document.createElement("INPUT");
	
	//le añadimos al botón varios atributos
	boton.setAttribute("type","submit");
	boton.setAttribute("value","Enviar Datos");
	boton.setAttribute("onclick","enviarDatos()");
	
	//recogemos el padre de ese elemento
	var form = document.getElementsByTagName("FORM")[0];
	//y lo insertamos al pricipio dentro del padre
	form.insertBefore(boton,form.firstChild);

}

//la siguiente funcion cambia el estilo del elemento para que sea visible
function mostrar(elemento){
	elemento.style.display = "block";
}

//esta funcion crea nueva respuestas
function crearRespuesta(){
	
	//llamamos a la funcion añadir elemento pasandole como parametro las funciones crearLabel y crearInput
	añadirElemento(crearLabel(),crearInput());

}

//la siguiente funcion crea un label nuevo
function crearLabel(){
		
	//creamos el elemento y lo guardamos en una variable
	var labelNuevo = document.createElement("LABEL");

	//creamos un texto nuevo y lo guardamos en una variable
	var textoNuevo = document.createTextNode("Respuesta " + cantidadRespuestas + ":");
	//añadimos dicho texto al nuevo label
	labelNuevo.appendChild(textoNuevo);
	

	//devolvemos el nuevo label
	return labelNuevo;
	
}

//la siguiente funcion crea un input nuevo
function crearInput(){
	//creamos el elemento y lo guardamos en una variable
	var inputNuevo = document.createElement("INPUT");
	//le añadimos varios atributos al input
	inputNuevo.setAttribute("name","respuesta[]");
	inputNuevo.setAttribute("onBlur","inputVacio(event)");
	inputNuevo.setAttribute("required","true");
	//devolvemos el nuevo input
	return inputNuevo;
	
}

//añade elementos que se han pasado a un div que crea de cero y lo añade a la pagina
function añadirElemento(elemento1,elemento2){	
	//guardamos en una variable el padre donde se van a crear el nuevo Label y el nuevo Input
	var padre = document.createElement("DIV");
		
	//le añadimos al padre un atributo id
	padre.setAttribute("id",cantidadRespuestas);
	
	//este if comprueba las respuestas, y solo a partir de la 3r respuesta añade el botón ELIMINARUNICARESPUESTA
	if(padre.id == 1 || padre.id == 2){
		padre.appendChild(elemento1);
		padre.appendChild(elemento2);
	}else{
		padre.appendChild(elemento1);
		padre.appendChild(elemento2);
		padre.appendChild(botonEliminar());
	}

	//añadimos tambien los botones subir respuesta o bajar respuesta
	padre.appendChild(botonSubir());
	padre.appendChild(botonBajar());
	//hacemos que todos los divs que creamos tenga la misma clase, en este caso respuesta
	padre.setAttribute("class","respuestas");
	
	
	//sumamos 1 a la variable global cantidadRespuestas 
	cantidadRespuestas++;
	
	
	//por ultimo guardamos en una variable el padre general de cada div
	var form = document.getElementsByTagName("FORM")[0];
	//y se lo añadimos
	form.appendChild(padre);
	
	//comprobamos que boton subir/bajar respuesta hay que deshabilitar
	deshabilitarBotonSubirBajar();

}

//comprobamos que boton subir/bajar respuesta hay que deshabilitar
function deshabilitarBotonSubirBajar(){
	//recogemos todos los divs con la clase respuesta y lo guardamos en una array
	var arrayDivsRespuestas = document.querySelectorAll("DIV [class='respuestas']");
	
	var texto;
	//comprobamos la id de los div
	for(var i = 0; i < arrayDivsRespuestas.length; i++){
		
		if(arrayDivsRespuestas[i].id == 1){
			//en caso de que sea la id 1 deshabilita solo el boton subir respuesta
			document.querySelector("BUTTON[name='subir1']").disabled = true;
			document.querySelector("BUTTON[name='bajar1'").disabled = false;
			
			}else if(arrayDivsRespuestas[i].id == arrayDivsRespuestas.length){
				//en caso de que sea el ultimo div de todos solo deshabilita el boton bajar respuesta
				texto = "subir"+arrayDivsRespuestas[i].id;
				document.querySelector("BUTTON[name='"+texto+"'").disabled = false;
				
				texto = "bajar"+arrayDivsRespuestas[i].id;
				document.querySelector("BUTTON[name='"+texto+"'").disabled = true;
			}else{
				//si se trata de cualquier otro habilitara los dos botones
				texto = "subir"+arrayDivsRespuestas[i].id;
				document.querySelector("BUTTON[name='"+texto+"']").disabled = false;	
			
				texto = "bajar"+arrayDivsRespuestas[i].id;
				document.querySelector("BUTTON[name='"+texto+"'").disabled = false;
			}
	}
	
}

//esta funcion solo crea un boton que tendrá una función en específico
function botonEliminar(){
	var botonEliminar = document.createElement("BUTTON");
	botonEliminar.setAttribute("onclick","eliminarRespuestaUnica(event)");
	botonEliminar.appendChild(document.createTextNode("X")); 
	return botonEliminar;
}

//esta funcion solo crea el botón de subir respuesta con una función en específico
function botonSubir(){
	var botonSubirElem = document.createElement("BUTTON");
	botonSubirElem.setAttribute("onclick","subirTextoInput(event)");
	botonSubirElem.setAttribute("type","button");
	botonSubirElem.setAttribute("name","subir"+cantidadRespuestas);
	botonSubirElem.appendChild(document.createTextNode("▲")); 
	return botonSubirElem;

}

//esta funcion solo crea el botón de bajar respuesta con una función en específico
function botonBajar(){
	var botonBajarElem = document.createElement("BUTTON");
	botonBajarElem.setAttribute("onclick","bajarTextoInput(event)");
	botonBajarElem.setAttribute("type","button");
	botonBajarElem.setAttribute("name","bajar"+cantidadRespuestas);
	botonBajarElem.appendChild(document.createTextNode("▼")); 
	return botonBajarElem;

}

//esta funcion intercambia la respuesta con la de arriba
function subirTextoInput(event){
	var divPadreID = event.currentTarget.parentNode.id;
	var arrayDivsRespuestas = document.querySelectorAll("DIV [class='respuestas']");
	
	for(var i = 0; i < arrayDivsRespuestas.length; i++){
		if(arrayDivsRespuestas[i].id == divPadreID){
			var valor1 = arrayDivsRespuestas[i].querySelector("INPUT").value;
			var valor2 = arrayDivsRespuestas[i-1].querySelector("INPUT").value;
			arrayDivsRespuestas[i].querySelector("INPUT").value = valor2;
			arrayDivsRespuestas[i-1].querySelector("INPUT").value = valor1;
			
			arrayDivsRespuestas[i-1].querySelector("INPUT").setAttribute("value", valor1);
			arrayDivsRespuestas[i].querySelector("INPUT").setAttribute("value", valor2);
		}
	
	}
}

//esta funcion intercambia la respuesta con la de abajo
function bajarTextoInput(event){
	var divPadreID = event.currentTarget.parentNode.id;
	var arrayDivsRespuestas = document.querySelectorAll("DIV [class='respuestas']");
	
	for(var i = 0; i < arrayDivsRespuestas.length; i++){
		if(arrayDivsRespuestas[i].id == divPadreID){
			var valor1 = arrayDivsRespuestas[i].querySelector("INPUT").value;
			var valor2 = arrayDivsRespuestas[i+1].querySelector("INPUT").value;
			arrayDivsRespuestas[i].querySelector("INPUT").value = valor2;
			arrayDivsRespuestas[i+1].querySelector("INPUT").value = valor1;
			
			arrayDivsRespuestas[i+1].querySelector("INPUT").setAttribute("value", valor1);
			arrayDivsRespuestas[i].querySelector("INPUT").setAttribute("value", valor2);
		}
	
	}
	
}

//elimina todas las respuestas excepto la respuesta 1 y 2
function eliminarRespuestas(){
	
	//recorremos todos los divs que tenemos en el documento
	var arrayDivs = document.querySelectorAll("div [class='respuestas']");
	
	//por cada div que encuentre ejecutara una funcion (excepto para el DIV con ID "1" y el DIV con ID "2")
	for(var i = arrayDivs.length; i > 2 ; i--){
			eliminarElemento(arrayDivs[i-1]);
	}
	//devolvemos la variable global cantidadRespuestas a 3
	cantidadRespuestas = 3;
	deshabilitarBotonSubirBajar();
}

//se elimina de dentro del form el elemento que se le pasa 
function eliminarElemento(elemento){
	//recoge el padre general del elemento pasado
	var padre = document.getElementsByTagName("form")[0];
	//y eliminamos el elemento
	padre.removeChild(elemento);
	
}

//comprueba los inputs y ejecutan si pierden el foco
function inputVacio(event){
	var elemento = event.currentTarget;
	if(elemento.value.length == 0){
		elemento.style.boxShadow = "-1px 1px 20px red";
	}else{
		elemento.style.boxShadow = "none";
	}
}
//la siguiente funcion crea los inputs y el label para la fecha de inicio
function crearFechaInicio(){
	var fechaInicio = document.createElement("LABEL");
	fechaInicio.appendChild(document.createTextNode("Fecha de Inicio"));
	dia ++;
	if(dia < 10 ){
		dia = "0"+dia;
	}
	if(mes < 10){
		mes = "0"+mes;
	}
	var fecha = ano+"-"+mes+"-"+dia;
	
	var fechaInput = document.createElement("INPUT");
	fechaInput.setAttribute("type","date");
	fechaInput.setAttribute("name","fechaInicio");
	fechaInput.setAttribute("min",fecha);
	fechaInput.setAttribute("onblur","habilitarFechaFinal()");
	fechaInput.setAttribute("required","true");
	fechaInicio.appendChild(fechaInput);
	
	var divPadre = document.createElement("DIV");
	divPadre.appendChild(fechaInicio);
	
	var hora = document.createElement("INPUT");
	hora.setAttribute("type","time");
	hora.setAttribute("name","horaInicio");
	hora.setAttribute("onblur","habilitarHoraFinal()");
	hora.setAttribute("required","true");
	divPadre.appendChild(hora);
	
	
	var padre = document.getElementsByTagName("form")[0];
	padre.insertBefore(divPadre, padre.firstChild);
	
	
}

//la siguiente funcion crea los inputs y el label para la fecha de cierre
function crearFechaFinal(){
	var fechaFinal = document.createElement("LABEL");
	fechaFinal.appendChild(document.createTextNode("Fecha de Final"));

	
	var fechaInput = document.createElement("INPUT");
	fechaInput.setAttribute("required","true");
	fechaInput.setAttribute("type","date");
	fechaInput.setAttribute("name","fechaFinal");
	//~ fechaInput.setAttribute("onblur","fechaMax()");

	fechaFinal.appendChild(fechaInput);
	
	var divPadre = document.createElement("DIV");
	divPadre.appendChild(fechaFinal);
	
	var hora = document.createElement("INPUT");
	hora.setAttribute("type","time");
	hora.setAttribute("name","horaFinal");
    hora.setAttribute("onblur","deshabilitarBotonSubirBajar()");
	hora.setAttribute("required","true");
	divPadre.appendChild(hora);
	
	var padre = document.getElementsByTagName("form")[0];
	padre.insertBefore(divPadre,padre.firstChild.nextSibling);
}

/* ÉSta función comprobava las fechas y en caso de que fueran iguales o la fecha final fuera menor a la fecha de inicio
 * se resaltaba dicho input con color naranja
function fechaMax(){
	var fechaFinal = document.querySelector("input[name='fechaFinal']");
	var fechaInicio = document.querySelector("input[name='fechaInicio']");
	
	
	if(fechaFinal.value < fechaInicio.value && fechaFinal.value == fechaInicio.value){
		fechaFinal.focus();
		fechaFinal.style.boxShadow = "-1px 1px 20px orange";
	}else{
		fechaFinal.style.boxShadow = "none";
	}
	
}
*/

//esta función solo elimina la respuesta que haya sido clicada
function eliminarRespuestaUnica(event){
	var padre = document.getElementsByTagName("form")[0];
	
	var padreDiv = event.currentTarget.parentNode;
	
	padre.removeChild(padreDiv);
	
	var hermanosArray = padre.querySelectorAll("div [class='respuestas']");
	
	eliminarRespuestas();
	for(var i = 2; i < hermanosArray.length; i++){
			var label = crearLabel();
			var input = crearInput();
			input.setAttribute("value",hermanosArray[i].querySelector("INPUT").value);
			añadirElemento(label,input);
	}
}	

//habilita el input para la fecha final y hace que la fecha minima sea la escogida en fechaInicio
function habilitarFechaFinal(){
	var fechaInicio = document.querySelector("input[name='fechaInicio']");
	var fechaFinal = document.querySelector("input[name='fechaFinal']");
	
	var yy = parseInt(fechaInicio.value.split("-")[0]);
	var mm = parseInt(fechaInicio.value.split("-")[1]);
	var dd = parseInt(fechaInicio.value.split("-")[2]);
	dd++;
	var fecha = yy+"-"+mm+"-"+dd;
	
	fechaFinal.setAttribute("min",fecha);
	fechaFinal.disabled = false;
	
	document.querySelector("input[name='horaInicio']").disabled = false;
	
}

//habilita simplemente el input horaFinal
function habilitarHoraFinal(){

	document.querySelector("input[name='horaFinal']").disabled = false;
}
