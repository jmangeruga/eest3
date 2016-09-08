$(document).ready(function(){
	loadFecha();
	/******** Efectos en el menu ********/	
	$(".itmen").mouseover(function(e){
		$(this).animate({'letter-spacing':"5px"},"fast","linear");	
	});
	$(".itmen").mouseout(function(e){
		$(this).animate({'letter-spacing':"0px"},"fast","linear");
	});
        $("a.oc-novedades").click(function(e){
          if ($(".novedades").attr("mostrar") == "false"){
                $(".novedades").attr("mostrar","true");
        	$(".novedades").fadeOut('slow');
          }else{
                $(".novedades").attr("mostrar","false");
        	$(".novedades").fadeIn('slow');
          }	
        });
        
	marcarItemActual();
});


function marcarItemActual(){
	$(".actual").removeClass("actual");
	var itemActual = $(".contenido").attr("id");
	$("#ir"+itemActual).addClass("actual");
	
}

var ultimaURL = "";

var nombreDia = new Array(7);
nombreDia[0] = "DOM";
nombreDia[1] = "LUN";
nombreDia[2] = "MAR";
nombreDia[3] = "MIE";
nombreDia[4] = "JUE";
nombreDia[5] = "VIE";
nombreDia[6] = "SAB";
var nombreMes = new Array(12);
nombreMes[0] = "01";
nombreMes[1] = "02";
nombreMes[2] = "03";
nombreMes[3] = "04";
nombreMes[4] = "05";
nombreMes[5] = "06";
nombreMes[6] = "07";
nombreMes[7] = "08";
nombreMes[8] = "09";
nombreMes[9] = "10";
nombreMes[10] = "11";
nombreMes[11] = "12";

function loadFecha(){
	var fecha = new Date();
	var diaSemana = fecha.getDay();
	var diaMes = fecha.getDate();
	var mes = fecha.getMonth();
	var anio = fecha.getFullYear();
	var fechaMostrada = "<p>"+nombreDia[diaSemana]+" "+diaMes+"."+nombreMes[mes]+"."+anio+"</p>";
	$("#fecha-actual").html(fechaMostrada);}
