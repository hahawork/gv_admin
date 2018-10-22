
var idUsuario = 0;

function onRBUsuariosChange(rbUsuarios) {
    idUsuario = 0;
    SetAllCheckBoxes('frmcheckboxs', 'items', false);
    idUsuario = rbUsuarios;
    console.log(rbUsuarios);

    $.ajax({
        type: 'POST',
        cache: false,
        dataType: 'text',
        url: "asignarrolespermisos/ObtenerRolesPermisosPorUsuario.php",
        data: {
            idUsuario: idUsuario
        },
        success: function (data) {

                var a = data.split(",");
                for (var i = 0; i <= a.length; i++) {
                    var b = a[i];
                    console.log(b);
                    document.getElementById(b).checked=true;
                }                
        }
    });
}

function SetAllCheckBoxes(FormName, FieldName, CheckValue)
{
	if(!document.forms[FormName])
		return;
	var objCheckBoxes = document.forms[FormName].elements[FieldName];
	if(!objCheckBoxes)
		return;
	var countCheckBoxes = objCheckBoxes.length;
	if(!countCheckBoxes)
		objCheckBoxes.checked = CheckValue;
	else
		// set the check value for all check boxes
		for(var i = 0; i < countCheckBoxes; i++)
			objCheckBoxes[i].checked = CheckValue;
}

function onCHKItemChanged(idSeccion, idItem, isActivo) {
    
    if (idUsuario > 0) {

        if (idSeccion > 0 & idItem > 0) {

            var activo = isActivo.checked ? 1 : 0;
            console.log("se procede a guardar usuario: " + idUsuario + ", seccion: " + idSeccion + ", item: " + idItem + ", estado: " + activo);
            $.ajax({
                type: "post",
                cache: false,
                dataType: 'json',
                url: "asignarrolespermisos/ActivarDesactAccesoItemUsuario.php",
                data: {
                    idUsuario: idUsuario,
                    idMenuSeccion: idSeccion,
                    idMenuItem: idItem,
                    EstadoActivo: activo
                },
                success: function (data) {
                    if (data.success == 1) {

                    }
                }
            });
        }
    } else {
        isActivo.checked = !isActivo.checked;
        alert("Primero seleccione un usuario");
    }
}