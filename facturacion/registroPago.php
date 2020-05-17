<!DOCTYPE html>
<html lang="es">
    <head>
        <title>GESTIÓN TESORERIA</title>
        <?php 
        $ruta='./../';
        require($ruta.'include/php/links.php');
        ?>
        <link rel="stylesheet" href="./custom/css/registroPago.css">
    </head>

    <body>
        <!-- header -->
        <?php include($ruta.'include/menu/php/ns_header.php'); ?>
        <!-- header -->

       
     
        <div class="my-contenido-web">
            <div id="my_titulo" class="text-center uGreen my-tam-per border-bottom border-warning">
                    <span class="">Registro Pago</span>
            </div>
            <div class="my-content-shadow">
                    <div class="col-lg-12">
                        <div class="row">

                            <div class="col-lg-6 px-1">
                                <div class="input-group input-group-sm my-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text border border-my-buscar"
                                            title="Usuario">
                                            NÚMERO RUC
                                        </span>
                                    </div>
                                    <input class="form-control border-buscar-text"
                                        type="text"
                                        name="my_reg_ruc_comp"
                                        id="my_reg_ruc_comp"
                                        autocomplete="off"
                                        title="Número RUC"
                                        disabled>

                                    <button type="button" class="btn border-my-buscar btn-group btn-sm" 
                                        onclick="buscarCliente();" title="Buscar cliente">
                                        <i class="fa fa-search p-1"></i>
                                    </button>
                                </div>

                                <div class="input-group input-group-sm my-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text my-otros-span">
                                            RAZÓN SOCIAL</span>
                                    </div>
                                    <input class="form-control my-otros-text"
                                        type="text"
                                        name="my_reg_nombre_comp"
                                        id="my_reg_nombre_comp"
                                        autocomplete="off"
                                        title="Nombre completo"
                                        disabled>
                                </div>

                                <div class="col-lg-12 px-1" style="padding-top: 50px">
                                    <button class="btn btn-warning btn-sm my-1 my-texto-ob" type="button" id="btn-nuevo" 
                                            onclick="nuevaVenta();" title="Nuevo">
                                        <i class="fa fa-sticky-note tam-icon pr-2"></i>Nuevo</button>
                                    <button class="btn btn-info btn-sm my-1 my-texto-ob" type="button" id="btn-registrar" 
                                            onclick="regPagoServicio();" title="Registrar" disabled>
                                        <i class="fa fa-floppy-o tam-icon pr-2"></i>Registrar</button>
                                    
                                    <button class="btn btn-info btn-sm my-1 my-texto-ob" type="button" id="btn-imprimir" 
                                            onclick="imprimirBoleta();" title="Registrar" disabled>
                                        <i class="fa fa-floppy-o tam-icon pr-2"></i>Imprimir</button>
                                
                                    <button class="btn btn-danger btn-sm my-1 my-texto-ob" type="button" id="btn-cancelar"
                                            onclick="cancelarAccion();"  title="Cancelar" disabled>
                                        <i class="fa fa-ban tam-icon pr-2"></i>Cancelar</button>
                                </div>
                            </div>
                            

                            <div class="col-lg-6 px-1">
                                <div class="input-group input-group-sm my-1">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text my-otros-span">
                                            SERVICIO</span>
                                    </div>
                                    <input class="form-control my-otros-text"
                                        type="text"
                                        name="my_bus_servicio"
                                        id="my_bus_servicio"
                                        autocomplete="off"
                                        title="Nombre servicio" 
                                        onkeyup="getServicio();">
                                </div>

                                <div class="col-lg-12 p-0" style="height: 120px;">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover table-bordered " id="my-t-principal" >
                                            <thead class="d-none">
                                                <tr class="my-t-header"  style="width: 100%;">
                                                    <td class="text-center" style="width: 10px;">N°</td>
                                                    <td class="text-center" style="width: 180px;">Concepto</td>
                                                    <td class="text-center" style="width: 40px;">Precio</td>    
                                                </tr>
                                            </thead>
                                            <tbody class="my-t-body" id="my-t-bus-cliente">
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                
            </div>
            <div class="col-lg-12" style="height: 300px;">
                <div class="col-lg-12 p-0 mt-3">        
                    <div class="table-responsive">
                        <table class="table table-sm table-hover table-bordered" id="my-t-principal" >
                            <thead>
                                <tr class="my-t-header">
                                    <td class="text-center" style="width: 10px;">N°</td>
                                    <td class="text-center" style="width: 120px;">Concepto</td>
                                    <td class="text-center" style="width: 30px;">Precio</td>
                                    <td class="text-center" style="width: 30px;">Eliminar</td>     
                                </tr>
                            </thead>
                            <tbody class="my-t-body" id="my_t_boleta">
                              <tr class="d-none"></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="my-contenedor-float">
                    <label for="my_total" style="color: black;" readonly disabled>TOTAL: S/.</label>
                    <input type="text" id="my_total" name="my_total" value="0.00" style="border: none; background: white; color: black; width: 60px;" readonly disabled>
                </div>
               
            </div>
        </div>
      
    <!-- Modal Buscar Cliente -->
    <div class="modal fade" id="miModalBusCli" class="miModalBusUsu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header my-header-modal my-cursor-mov">
                    <h5 class="modal-title my-text-white">Buscar Cliente</h5>
                    <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
                        <span class="my-modal-close" aria-hidden="true" title="Cerrar">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="input-group input-group-sm my-1">
                        <input class="form-control border-buscar-text"
                            placeholder="Escribir el nombre de cliente"
                            type="text"
                            name="my_cli_buscado"
                            id="my_cli_buscado"
                            title="Buscar Cliente"
                            autocomplete="off"
                            onkeyup="getCliente();">

                    </div>
                    <div class="col-lg-12 p-0 table-responsive" style="height: 200px !important">
                        <table class="table table-sm table-hover table-bordered">
                            <thead>
                                <tr class="my-t-header">
                                    <td class="text-center" style="width: 20px;">N°</td>
                                    <td class="d-none"></td>
                                    <td class="text-center" style="width: 300px;">Razón Social</td>
                                    <td class="text-center" style="width: 50px;">RUC</td>      
                                </tr>
                            </thead>
                            <tbody class="my-t-buscado" id="my-t-buscado">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="text-right pr-3 pb-3">
                    <button type="button" class="btn btn-danger btn-sm" id="cerrarModalBU" 
                        data-dismiss="modal" aria-label="Close">Salir</button> 
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal BC -->
   
    <!-- Modal Des -->
    <div class="modal fade" id="miModalDes" class="miModatTitle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header my-header-modal my-cursor-mov">
                    <h5 class="modal-title my-text-white">Alerta</h5>
                    <button type="button" class="close"  data-dismiss="modal" aria-label="Close">
                        <span class="my-modal-close" aria-hidden="true" title="Cerrar">&times;</span>
                    </button>
                </div>
                <div class="modal-body pb-0">
                    <div class="col-lg-12 p-0 centrar-custom">
                        <div class="row">
                            <div class="col-lg-4 p-0 text-center">
                                <i class="fa fa-exclamation text-warning" 
                                    style="font-size:50px;"></i>
                            </div>
                            <div class="col-lg-8 p-0 text-center">
                                <h6 id="miModalDesTexto">--</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer py-1 border-0 align-self-center">
                    <button type="button" class="btn btn-success btn-sm" 
                        id="eventeame" style="width:65px;">Si</button>
                    <button type="button" class="btn btn-danger btn-sm" 
                        id="cerrarMiModalDes" data-dismiss="modal" aria-label="Close" 
                        style="width:65px;"> No</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modal Des -->

    <?php require($ruta.'include/php/ns_links.php'); ?>
    <script src="./custom/js/registroPago.js"></script>
    </body>
</html>