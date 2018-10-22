
	window.onload = selListProducto_AgregProd_change;

	function click_btnGuardarProducto(){

		var NombreProducto =  document.getElementById("txtProd_AgregProd").value;

		if (NombreProducto.length > 0) {

			$.ajax({
	          	type:'post',
	          	dataType:'json',
	          	cache:false,
	          	data: {Descripcion: NombreProducto, IdCliente: 1},
	          	url:'php/guarda_nuevo_producto.php',
	          	beforeSend: function() {
	          		document.getElementById("divefectoguardando").innerHTML = "Guardando...";
			       document.getElementById("divefectoguardando").style.display= 'block';
			    },
	          	success:function(res)
	          	{
	          		if (res.Guardado == 1 ) {

	          			document.getElementById("txtProd_AgregProd").value = "";
		          		MensajeAlerta('alertSuccess','mensajeS', 'Se ha guardado con éxito el nuevo producto. Por favor actualice la página <a href="planpromocional_agregarproducto.php"> Aqui</a>');		          		
		    
		          	}else{

		          		MensajeAlerta('alertWarning','mensajeW', 'Error al guardar el nuevo producto.');
		          	}

		          	document.getElementById("divefectoguardando").style.display= 'none';

	          	}
		  	});
		}else{
			MensajeAlerta('alertDanger','mensajeD', 'Por favor Ingrese el nombre del nuevo producto.');
			document.getElementById("txtProd_AgregProd").focus();
		}
	}

	
	function click_btnGuardarMarca(){

		var NombreMarca =  document.getElementById("txtMarca_AgregProd").value;
		var idProductomarca = document.getElementById("selListProducto_AgregMarca").value;

		if (NombreMarca.length > 0) {

			$.ajax({
	          	type:'post',
	          	dataType:'json',
	          	cache:false,
	          	data: {IdProducto: idProductomarca, Descripcion: NombreMarca},
	          	url:'php/guarda_nueva_marca.php',
	          	beforeSend: function() {
	          		document.getElementById("divefectoguardando").innerHTML = "Guardando...";
			       document.getElementById("divefectoguardando").style.display= 'block';
			    },
	          	success:function(res)
	          	{
	          		if (res.Guardado == 1 ) {

	          			document.getElementById("txtMarca_AgregProd").value = "";
		          		MensajeAlerta('alertSuccess','mensajeS', 'Se ha guardado con éxito la nueva marca. Por favor actualice la página <a href="planpromocional_agregarproducto.php"> Aqui</a>');
		    
		          	}else{

		          		MensajeAlerta('alertWarning','mensajeW', 'Error al guardar la nueva marca. ' + res.error);
		          	}

		          	document.getElementById("divefectoguardando").style.display= 'none';

	          	}
		  	});
		}else{
			MensajeAlerta('alertDanger','mensajeD', 'Por favor Ingrese el nombre de la nueva marca.');
			document.getElementById("txtMarca_AgregProd").focus();
		}
	}


	function click_btnGuardarPresentacion(){

		var idp =  document.getElementById("txtPresentacion_AgregProd").value;
		var NombrePresentacion =  document.getElementById("txtPresentacion_AgregProd").value;
		var idProductomarca = document.getElementById("selListMarca_AgregProd").value;
		var ccs = document.getElementById("txtCCS_AgregProd").value;
        var ccmantica = document.getElementById("txtCCM_AgregProd").value;
        var cwalmart = document.getElementById("txtCW_AgregProd").value;
        var cbarra = document.getElementById("txtCB_AgregProd").value;
        var descripcion = document.getElementById("txtDesc_AgregProd").value;
        var IdCanal = document.getElementById("txtCanal_AgregProd").value;

        console.log(descripcion);

		if (idProductomarca > 0) {
			console.log(idProductomarca);
			if (descripcion.length > 0) {

				$.ajax({
		          	type:'post',
		          	dataType:'json',
		          	cache:false,
		          	data: {IdCliente: 1, IdMarca:idProductomarca, CodCafeSoluble:ccs,
		          		CodCasaMantica: ccmantica, CodigoWalmart:cwalmart, CodigoBarras: cbarra, Descripcion: descripcion,
		          		IdCanal:IdCanal},
		          	url:'php/guarda_nueva_presentacion.php',
		          	beforeSend: function() {
		          		document.getElementById("divefectoguardando").innerHTML = "Guardando...";
				       	document.getElementById("divefectoguardando").style.display= 'block';
				    },
		          	success:function(res)
		          	{
		          		if (res.Guardado == 1 ) {

		          			//document.getElementById("txtPresentacion_AgregProd").value = "";
			          		MensajeAlerta('alertSuccess','mensajeS', 'Se ha guardado con éxito la nueva presentacion. Por favor actualice la página <a href="planpromocional_agregarproducto.php"> Aqui</a>');
			    
			          	}else{

			          		MensajeAlerta('alertWarning','mensajeW', 'Error al guardar la nueva presentacion. ' + res.error);
			          	}

			          	document.getElementById("divefectoguardando").style.display= 'none';

		          	}
			  	});
			}else{
				MensajeAlerta('alertDanger','mensajeD', 'Por favor Ingrese el nombre de la nueva presentacion.');
				document.getElementById("txtPresentacion_AgregProd").focus();
			}
		}else{
			MensajeAlerta('alertDanger','mensajeD', 'Por favor seleccione una marca.');
			document.getElementById("selListMarca_AgregProd").focus();
		}
	}

	function click_btnActualizarPresentacion(){

		var idp =  document.getElementById("txtPresentacion_AgregProd").value;
		var NombrePresentacion =  document.getElementById("txtPresentacion_AgregProd").value;
		var idProductomarca = document.getElementById("selListMarca_AgregProd").value;
		var ccs = document.getElementById("txtCCS_AgregProd").value;
        var ccmantica = document.getElementById("txtCCM_AgregProd").value;
        var cwalmart = document.getElementById("txtCW_AgregProd").value;
        var cbarra = document.getElementById("txtCB_AgregProd").value;
        var desc = document.getElementById("txtDesc_AgregProd").value;
        var IdCanal = document.getElementById("txtCanal_AgregProd").value;

		if (idProductomarca > 0) {
			console.log(idProductomarca);
			if (NombrePresentacion.length > 0) {

				$.ajax({
		          	type:'post',
		          	dataType:'json',
		          	cache:false,
		          	data: {IdPresentacion: idp, IdCliente: 1, IdMarca:idProductomarca, CodCafeSoluble:ccs,
		          		CodCasaMantica: ccmantica, CodigoWalmart:cwalmart, CodigoBarras: cbarra, Descripcion: desc,
		          		IdCanal:IdCanal},
		          	url:'php/actualiza_presentacion.php',
		          	beforeSend: function() {
		          		document.getElementById("divefectoguardando").innerHTML = "Guardando...";
				       	document.getElementById("divefectoguardando").style.display= 'block';
				    },
		          	success:function(res)
		          	{
		          		if (res.Guardado == 1 ) {

		          			//document.getElementById("txtPresentacion_AgregProd").value = "";
			          		MensajeAlerta('alertSuccess','mensajeS', 'Se ha actualizado con éxito la nueva presentacion. Por favor actualice la página <a href="planpromocional_agregarproducto.php"> Aqui</a>');
			    
			          	}else{

			          		MensajeAlerta('alertWarning','mensajeW', 'Error al actualizar la nueva presentacion. ' + res.error);
			          	}

			          	document.getElementById("divefectoguardando").style.display= 'none';

		          	}
			  	});
			}else{
				MensajeAlerta('alertDanger','mensajeD', 'Por favor Ingrese el nombre de la nueva presentacion.');
				document.getElementById("txtPresentacion_AgregProd").focus();
			}
		}else{
			MensajeAlerta('alertDanger','mensajeD', 'Por favor seleccione una marca.');
			document.getElementById("selListMarca_AgregProd").focus();
		}
	}

	function selListProducto_AgregProd_change(){


		var idp =  document.getElementById("selListProducto_AgregProd").value;

		$.ajax({
          	type:'get',
          	dataType:'html',
          	cache:false,
          	data: {idProducto: idp},
          	url:'php/marcas.php',
          	beforeSend: function() {

          		document.getElementById("divefectoguardando").innerHTML = "Cargando...";
		        document.getElementById("divefectoguardando").style.display= 'block';
		    },
          	success:function(res)
          	{
         
          		select = document.getElementById('selListMarca_AgregProd') .innerHTML = res;
          		document.getElementById("divefectoguardando").style.display= 'none';
          	}
	  	});
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