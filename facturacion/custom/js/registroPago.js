$(document).ready(function() {
    cancelarAccion();
});

inicializarVirtualSpace();

function inicializarVirtualSpace(){
    window.ns_registro ={
        control: "",
        cliente: 0,
    }
}

function buscarCliente(){
    abrirModalBC();
}

function abrirModalBC(){
    $('#miModalBusCli').css({
        top: 0, left: 0
    });

    $("#miModalBusCli").draggable({
        handle: ".modal-header"
    });

    $('#miModalBusCli').modal('show');
 
    $('#miModalBusCli').on('shown.bs.modal', function () {
        document.getElementById("my_cli_buscado").focus();
    });
}

function miModalBusCliClose(){
    $("#miModalBusCli .close").click();
}

function nuevaVenta(){
    habilitarNuevo(true);
    eliminarFilas();
}

function getServicio(){
    $.ajax({                    
        type: "POST",
        url: './controller/getBusquedaServicio.php',
        data: { valor: document.getElementById("my_bus_servicio").value},                  
        success: function(info){   
            $("#my-t-bus-cliente").html(info);
        }
    }).done(function(){
            
    });
}

function getCliente(){
    $.ajax({                    
        type: "POST",
        url: './controller/getBusquedaCliente.php',
        data: { valor: document.getElementById("my_cli_buscado").value},                  
        success: function(info){   
            $("#my-t-buscado").html(info);
        }
    }).done(function(){
        
    });
}

function habilitarNuevo(isNot){
    isNot = !isNot;
    $("#btn-registrar").prop("disabled", isNot);
    $("#btn-cancelar").prop("disabled", isNot);
    $("#btn-nuevo").prop("disabled", !isNot);
}

function cancelarAccion(){
    habilitarNuevo(false);
    $("#btn-imprimir").prop("disabled", true);
    window.ns_registro.cliente = 0;
    eliminarFilas();
}

function pintarFilaSelec(objeto) {
    $("#my-t-buscado").find("tr").each(function() {
        $(this).attr("style", "background-color: white");
    });

    $(objeto).attr("style", "background-color: #ffc107 !important");
}

function buscarFilaSelec(objeto){
    var fila = $(objeto).find("td");
    document.getElementById("my_reg_nombre_comp").value = $(fila[2]).text();
    document.getElementById("my_reg_ruc_comp").value = $(fila[3]).text();
    window.ns_registro.cliente = $(fila[1]).text();
    miModalBusCliClose();
}


//MOD 02-02-2020 
function getPagoServicio(objeto){
    var contenedor = document.getElementById("my_t_boleta").insertRow();
    $(objeto).css({"background-color": "#FDFD96"});

    var dato0 =objeto.cells[0].innerText;
    var dato1 =objeto.cells[1].innerText;
    var dato2 =objeto.cells[2].innerText;
    var dato3 =objeto.cells[3].innerText;

    contenedor.innerHTML = "<tr class='text-center'>" + 
    "<td class='d-none' >" + dato0 + "</td>" +
    "<td class='text-center' >" + dato1 + "</td>" + 
    "<td class='text-center' >" + dato2 + "</td>" + 
    "<td class='text-center' ><input type='text' class='text-center' value=" + dato3 +" onchange='recalculoTotal();'></td>" + 
    "<td class='text-center' ><button type='button' class='btn btn-danger btn-sm px-1 py-0' onclick='eliminarFila(this);'><i class='fa fa-window-close'></i></button></td>" +
    "</tr>";

    sumarPrecio(dato3.toString());
    noRepetirServicio(dato1, contenedor);
}

function noRepetirServicio(codigo, contenedor){
    var tabla = document.getElementById('my_t_boleta');
    var filas = tabla.rows.length;
    if(filas > 1 &&  filas != null && typeof filas != "undefined"){
        var mycodigo = 0;
        var mycont = 0;
        for (var r = 1; r < filas; r++) {
            mycodigo = tabla.rows[r].cells[1].innerText;
            if(codigo == mycodigo){
                mycont +=1;
            }
            if(mycont == 2){
                $(contenedor).remove();
            }
        }
    }
    recalculoTotal();
}

function eliminarFila(objeto){
    var contenedor = $(objeto).parent().parent();
    var fila = $(contenedor).find("input");
    var precio_eli = $(fila[0]).val();
    restarPrecio(precio_eli);
    despintarPagoServicio(contenedor);
    $(contenedor).remove();
}

function despintarPagoServicio(objeto){
    var my_fila = $(objeto).find("td");
    var my_valor =  $(my_fila[1]).text();
    var tabla = document.getElementById('my-t-bus-cliente');
    var filas = tabla.rows.length;
    var my_filas = $(tabla).find("tr");
    if(filas > 0 &&  filas != null && typeof filas != "undefined"){
        var mycodigo = 0;
        for (var r = 0; r < filas; r++) {
            mycodigo = tabla.rows[r].cells[1].innerText;
            if(my_valor == mycodigo){
                $(my_filas[mycodigo - 1]).css({"background-color": "#FFFFFF"});
                break;
            }
        }
    }
}

function sumarPrecio(precio){
    var p_c = document.getElementById("my_total").value;
    var p_t = parseFloat(p_c) + parseFloat(precio);
    document.getElementById("my_total").value = parseFloat(p_t).toFixed(2);
}

function restarPrecio(precio){
    var p_c = document.getElementById("my_total").value;
    var p_t = parseFloat(p_c) - parseFloat(precio);
    document.getElementById("my_total").value = parseFloat(p_t).toFixed(2);
}

//MOD 02-02-2020
function recalculoTotal(){
    var tabla = document.getElementById('my_t_boleta');
    var n = tabla.rows.length;
    var sumar = 0.00;
    for (var r = 1; r < n; r++) {
        sumar += parseFloat(tabla.rows[r].cells[3].getElementsByTagName("input")[0].value);
    }
    document.getElementById("my_total").value = parseFloat(sumar).toFixed(2);
}

function eliminarFilas(){
    var tabla = document.getElementById('my_t_boleta');
    var filas = tabla.rows.length - 1;
    if(filas > 0 &&  filas != null && typeof filas != "undefined"){
        for (var r = 0; r < filas; r++) {
            document.getElementById("my_t_boleta").deleteRow(1);
        }
        document.getElementById("my_total").value ="0.00";
    }
}

function regPagoServicio(){
    var tabla = document.getElementById('my_t_boleta');
    var filas = tabla.rows.length;
    var datoLista = [];
    if(filas > 1 &&  filas != null && typeof filas != "undefined"){
        for (var r = 1; r < filas; r++) {
            var celdas = new Array(3);
            celdas[0] = tabla.rows[r].cells[0].innerText;
            celdas[1] = tabla.rows[r].cells[1].innerText;
            celdas[2] = tabla.rows[r].cells[2].innerText;
            celdas[3] = tabla.rows[r].cells[3].getElementsByTagName("input")[0].value;
            datoLista.push(celdas);
        }
    }

    $.ajax({                    
        type: "POST",
        url: './controller/regPagoServicio.php',
        data: { datoLista: datoLista,
                mi_cliente: window.ns_registro.cliente
        },            
        success: function(info){
            if(info == "255"){
                $.notify("Alerta: Se registro correctamente", "info");
                $("#my_t_boleta").find("input,button").attr("disabled", "disabled");
                $("#btn-imprimir").prop("disabled", false);
                $("#btn-registrar").prop("disabled", true);
                $("#btn-cancelar").prop("disabled", true);
                window.ns_registro.control = info;
                window.ns_registro.cliente = 0;
            }else{
                $.notify("Alerta: " + info, "info");
            }            
        }
    }).done(function(){

    });
}

function imprimirBoleta(){
    habilitarNuevo(false);

    var form = document.createElement("form");
    form.target = "_blank";
    form.method = "POST";
    form.action = "./report/imprimirBoleta.php";
    form.style.display = "none";


    var input = document.createElement("input");
    input.type = "hidden";
    input.name = "surface_nc";
    input.value = document.getElementById("my_reg_nombre_comp").value;
    form.appendChild(input);

    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}