var divProductlis = document.getElementById('arrayProductPromo');
var addedProduct = document.getElementById('txtProducto').value;

var total = 0;
var arrProductosEnPromo = [""];
							            	
function on_nuevaMarca(){
	window.location.href='planpromocional_agregarproducto.php';
}

function txtProducto_onblur(){

	console.log('txtProducto_onblur');

	var producto = document.getElementById('txtProducto').value;

	if (producto.length > 0 ) {

		var Idpresentac = producto.split("-")

		if (!contains(arrProductosEnPromo, Idpresentac[0])) {

			arrProductosEnPromo.push(Idpresentac[0]);

			var element = document.createElement("div");
		    element.id = "DIVproductoagregado";
			element.class = "main";
			element.style = "background : #fff; font-size: 12px";
		    element.appendChild(document.createTextNode(producto));
		    divProductlis.appendChild(element);

		    console.log('producto agregado a la lista ' + Idpresentac[0]);
		}
	}else{
		console.log('no se ha seleccionado el producto');
	}
}


function on_Cancelar(){

	var IdGuardadoDelete = document.getElementById('txtIdGuardado').value;

	console.log('on_Cancelar IdGuardadoDelete ' + IdGuardadoDelete);

	if (IdGuardadoDelete > 0 ) {
		$.ajax({
	          type:'post',
	          dataType:'json',
	          cache:false,
	          data: {IdPromoDelete:IdGuardadoDelete},
	          url:'php/cancelar_plan_promocional.php',
	          success:function(res)
	          {		

	          	if (res.success > 0) {

					document.getElementById('divContenedorPdV').style.display = "none";	
					document.getElementById("txtMes").disabled = false; 
					document.getElementById("txtProducto").disabled = false;
					document.getElementById("txtZona").disabled = false;  
					document.getElementById("txtCantidad").disabled = false; 
					document.getElementById("txtActividad").disabled = false; 
					document.getElementById("btnAsignar").disabled = false; 					
					document.getElementById("txtPromocion").disabled = false; 
					document.getElementById("txtMaterialPOP").disabled = false; 
					document.getElementById("txtPremios").disabled = false; 
					document.getElementById("selListCanales").disabled = false;
					document.getElementById("selListMarcas").disabled = false;
						
					document.getElementById("txtActividad").value = ""; 
					document.getElementById("txtMes").value = ""; 
					document.getElementById("selListCanales").value = "0"; 
					document.getElementById("txtZona").value = ""; 
					document.getElementById("txtProducto").value = ""; 
					document.getElementById("txtCantidad").value = ""; 
					document.getElementById("txtPromocion").value = ""; 
					document.getElementById("txtMaterialPOP").value = ""; 
					document.getElementById("txtPremios").value = ""; 

					Marcas = "";
					document.getElementById('txtIdGuardado').value = 0;
					divProductlis.innerHTML = "";
					
					console.log('on_Cancelar candelado con exito');

					MensajeAlerta('alertSuccess','mensajeS', res.mensaje);

				}else{

					console.log('on_Cancelar no se ha podido cancelar');
					MensajeAlerta('alertDanger','mensajeD', res.error);

				}
	        }
		});
	}else{

		console.log('on_Cancelar solo limpiar');

		document.getElementById("txtActividad").value = ""; 
		document.getElementById("txtMes").value = ""; 
		document.getElementById("selListCanales").value = "0"; 
		document.getElementById("txtZona").value = ""; 
		document.getElementById("txtProducto").value = ""; 
		document.getElementById("txtCantidad").value = ""; 
		document.getElementById("txtPromocion").value = ""; 
		document.getElementById("txtMaterialPOP").value = ""; 
		document.getElementById("txtPremios").value = ""; 
		document.getElementById("selListMarcas").value = 0; 
		Marcas = "";
		document.getElementById('txtIdGuardado').value = 0;
		divProductlis.innerHTML = "";
		document.getElementById('divPdVConAsignacion').innerHTML = "";
		document.getElementById("btnGuardarAsignaciones").style.display='block';
	}
}


/*    eventos de los botones */

var listPresentaciones = "", TipoActividad, FechaInicio, FechaFin, CantidadDiasActividad, Canales, Departamentos, CantidadPaque;
var DescripcionActiv, MaterialPOP, Premios, IdCliente, IdUsuario, FechaReg, insertOK = 1;

function GuardarEditar() {	
	
	insertOK = 1;

	listPresentaciones = "";

	for (var i = 0; i < arrProductosEnPromo.length; i++) {

		listPresentaciones = listPresentaciones + arrProductosEnPromo[i];

		if (i == arrProductosEnPromo.length - 1) {
			continue;
		}
		if (i > 0 ) {
			listPresentaciones = listPresentaciones + ", ";
		}
	}

	TipoActividad = document.getElementById('txtActividad').value;
	FechaInicio = document.getElementById('txtFechaDesde').value;	
	FechaFin = document.getElementById('txtFechaHasta').value;
	CantidadDiasActividad = document.getElementById('txtCantidadDias').value;
	Canales = document.getElementById('selListCanales').value;
	Departamentos = document.getElementById('txtZona').value;
	CantidadPaque = document.getElementById('txtCantidad').value;
	DescripcionActiv = document.getElementById('txtPromocion').value;
	MaterialPOP = document.getElementById('txtMaterialPOP').value;
	Premios = document.getElementById('txtPremios').value;
	FechaReg = new Date().toISOString().slice(0,10);
	PDVoUNDMovil = document.querySelector('input[name = "rbTipoActividad"]:checked').value;


	if (TipoActividad.length == 0 || listPresentaciones.length == 0 || FechaInicio.length == 0 || 
		FechaFin.length == 0 || CantidadDiasActividad.length == 0 || Canales.length == 0 || 
		CantidadPaque.length == 0 || DescripcionActiv.length == 0 ){
		insertOK = 0;
	}
}

/*
$TipoActividad = $_POST['TipoActividad'];
	$Presentaciones = $_POST['Presentaciones'];
	$FechaInicio = $_POST['FechaInicio'];
	$FechaFin = $_POST['FechaFin'];
	$CantidadDiasActividad = $_POST['CantidadDiasActividad'];
	$Canales = $_POST['Canales'];
	$Departamentos = $_POST['Departamentos'];
	$CantidadPaque = $_POST['CantidadPaque'];
	$DescripcionActiv = $_POST['DescripcionActiv'];
	$MaterialPOP = $_POST['MaterialPOP'];
	$Premios = $_POST['Premios'];
	$IdCliente = $_POST['IdCliente'];
	$IdUsuario = $_POST['IdUsuario'];
	$FechaReg = $_POST['FechaReg'];
	$bolAsignado = $_POST['bolAsignado'];
	$bolRecibido = $_POST['bolRecibido'];
	$bolEntregado = $_POST['bolEntregado'];
	*/

function on_Asignar(IdClient, IdUser){

	GuardarEditar();

	if (insertOK == 1) {

		$.ajax({
          	type:'post',
          	dataType:'json',
         	cache:false,
          	data: {TipoActividad:TipoActividad,Presentaciones:listPresentaciones, FechaInicio:FechaInicio, 
          		FechaFin: FechaFin, CantidadDiasActividad:CantidadDiasActividad, Canales:Canales, 
          		Departamentos:Departamentos, CantidadPaque:CantidadPaque,
					DescripcionActiv:DescripcionActiv, MaterialPOP:MaterialPOP, Premios: Premios, 
					IdCliente:IdClient, IdUsuario:IdUser, FechaReg:FechaReg, PDVoUNIDMovil:PDVoUNDMovil, bolAsignado:0,
					bolRecibido:0, bolEntregado:0},
          	url:'php/guarda_nuevo_plan_promocional.php',
          	beforeSend: function() {
          		document.getElementById("divefectoguardando").innerHTML = "Guardando...";
		       	document.getElementById("divefectoguardando").style.display= 'block';
		    },
          	success:function(res)
          	{		

          		console.log('on_Asignar resmaxidpromo ' + res.maxIdpromo);
	          	if (res.maxIdpromo > 0) {

					document.getElementById('divContenedorPdV').style.display = "block";	
					document.getElementById("txtFechaDesde").disabled = true; 
					document.getElementById("txtFechaHasta").disabled = true; 
					document.getElementById("txtCantidadDias").disabled = true; 
					document.getElementById("txtProducto").disabled = true; 
					document.getElementById("txtActividad").disabled = true; 
					document.getElementById("selListCanales").disabled = true; 
					document.getElementById("selListMarcas").disabled = true; 
					document.getElementById("txtZona").disabled = true; 
					document.getElementById("txtCantidad").disabled = true; 
					document.getElementById("btnAsignar").disabled = true; 
					document.getElementById("txtMaterialPOP").disabled = true; 
					document.getElementById("txtPremios").disabled = true; 
					document.getElementById("txtPromocion").disabled = true; 
					document.getElementById("txtIdGuardado").value = res.maxIdpromo;

					document.getElementById("divefectoguardando").style.display= 'none';
					document.getElementById("divContenedorPdV").style.display= 'block';

					MensajeAlerta('alertSuccess','mensajeS', 'Guardado con  éxito.');
				}
				else{
				
					document.getElementById("divefectoguardando").style.display= 'none';
					console.log('on_Asignar no se ha podido guardar');
					MensajeAlerta('alertWarning','mensajeW', 'No se ha podido guardar. ' + res.error);
				
				}
          	},
          	error: function(data) {
	            console.log("NÃO FUNFOU!");
	        },
	        always: function(data) {
	            console.log("SEMPRE FUNFA!"); 
	            //A function to be called when the request finishes 
	            // (after success and error callbacks are executed). 
	        }
	  	});
	}
	else{
		MensajeAlerta('alertWarning','mensajeW', 'Verifique que los campos esten llenos');
	}
		
}

function GuardaAsignacionFinal(){

	var IdGuardadoFinalizar = document.getElementById('txtIdGuardado').value;

	if (IdGuardadoFinalizar > 0) {
		$.ajax({
			type:'post',
			dataType:'json',
			cache:'false',
			data:{idppPromocion: IdGuardadoFinalizar},
			url: 'php/guarda_asignacion_final_actividad.php',
			beforeSend: function (){
				console.log("Guardando... " + IdGuardadoFinalizar );
			},
			success: function(res){

				if (res.success == 1) {
					console.log("Se ha asignado con exito ");
					document.getElementById('txtIdGuardado').value = 0;
					alert("Se guardo todo con éxito");
					window.location.reload(true);

				}else{
					console.log("Fallo al finalizar. " + res.error);
				}
			},
			error: function(res){},
			always: function(res){}
		});
	}
}

function txtCantidad_onBlur(){

	var cantidtotal = document.getElementById("txtCantidad").value;
	document.getElementById("cantidadtotal").value = cantidtotal;
	document.getElementById("totaldisponible").value = cantidtotal;
}

function selListCanales_change(){
	var idc =  document.getElementById("selListCanales").value;
	console.log(idc);
	$.ajax({
      	type:'get',
      	dataType:'html',
      	cache:false,
      	data: {IdCanal: idc},
      	url:'php/get_pdv_x_idcanal.php',
      	beforeSend: function() {

	      	document.getElementById("divefectoguardando").innerHTML = "Cargando...";
		    document.getElementById("divefectoguardando").style.display= 'block';
	    },
      	success:function(res)
      	{
      		table = $('#tablepuntodeventa').DataTable( {
      			"destroy": true          					    
			} );
			 
			table.destroy();

			document.getElementById('tbody') .innerHTML = res;	
      		document.getElementById("divefectoguardando").style.display= 'none';   
			
	       tbl_pdv = $('#tablepuntodeventa').DataTable( {
		    	"paging": true,
		    	"destroy": true,
	          	"lengthChange": true,
	          	"searching": true,
	          	"ordering": true,
	          	"info": true,
	          	"autoWidth": true,	          	
		        "columnDefs": [ 
		        	{
		            	"targets": 1,
		            	"data": null,
		            	"defaultContent": "<input type='number'>"
		        	}
		        ]
		    } );
      	}
  	});
}

function selListMarcas_change(){


		var idm =  document.getElementById("selListMarcas").value;
		console.log(idm);
		$.ajax({
          	type:'get',
          	dataType:'html',
          	cache:false,
          	data: {IdMarca: idm},
          	url:'php/get_present_x_idmarca.php',
          	beforeSend: function() {

          		document.getElementById("divefectoguardando").innerHTML = "Cargando...";
		        document.getElementById("divefectoguardando").style.display= 'block';
		    },
          	success:function(res)
          	{
         		document.getElementById("txtProducto").value= "";
          		document.getElementById('listProducto') .innerHTML = res;
          		document.getElementById("divefectoguardando").style.display= 'none';
          	}
	  	});
	}

function onpress_ENTER(){
	 var keyPressed = event.keyCode || event.which;

    //if ENTER is pressed
    if(keyPressed==13)
    {
    	var valor = document.getElementById("txtCantidadAsignada").value; 
        alert('enter pressed ' + valor);
        keyPressed=null;
    }
    else
    {
        return false;
    }
}

function contains(arr, obj) {
    var i = arr.length;
    while (i--) {
       if (arr[i] === obj) {
           return true;
       }
    }
    return false;
}

function on_CerrarAlert(ev){

	var idpadre = ev.parentNode.id;

	document.getElementById(idpadre).style.display = "none";
}

/*
Muestra una alerta de acuerdo al tipo de parametro con un mensaje al usuario
*/
function MensajeAlerta(TipoAlerta, ContAlerta, MensajeAlerta){
	document.getElementById(TipoAlerta).style.display = "block";
	document.getElementById(ContAlerta).innerHTML = MensajeAlerta;
}