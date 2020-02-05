<div class="my-header-menu">
    <div class="col-lg-12 p-0">
                <div class="row">
                    <div class="col-lg-6 text-rigth">
                        <div class="row">
                            <div class="col-lg-2 p-0 centrar-custom">
                            
                                <img class="my-logo-per img-fluid" 
                                    src="<?php echo $ruta; ?>include/img/sistema.png" 
                                    onclick="rederigirInicio('<?php echo $ruta; ?>');"
                                    alt="USDG" title="USDG">
                                
                                <div class="my-menu-desplegable text-left">
                                    <input type="checkbox" id="uCheck" autocomplete="off" class="d-none">
                                    <label for="uCheck" class="uCentrarCustom mx-3 my-1" id="uLabel" onclick="clickLabel();">
                                        <i class="fa fa-bars border text-white rounded p-1" style="cursor:pointer"></i>
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-6 p-0 text-left">
                                <ul class="my-lista-logo">
                                    <li class="text-uppercase">FACTURACIÓN</li>
                                    <li class="text-uppercase">PHP Y SQL SERVER</li>
                                    <li class="text-underline"></li>
                                    <li class="">Autor: Maximo Hugo Bueno Uribe</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 text-right">
                        <div class="row">
                            <div class="col-lg-10 p-0 my-nombre-usuario">
                                <ul class="my-lista-logo">
                                    <li class="text-warning">
                                        <?php
                                            echo strtoupper("HBUENO"); 
                                        ?>
                                    </li>
                                    <li class="myCronoTime" id="myCronoTime">05:00</li>
                                    <li>
                                        <button type="button" class="my-btn-per" id="my-btn-menu-per" 
                                            onclick="abrirOpciones();">
                                            <img class="img-fluid my-img-svg-menu" 
                                                src="<?php echo $ruta; ?>include/img/icomenu.svg"  
                                                alt="Opciones" title="Opciones">
                                            <div class="my-usuario-opcion bg-white" id="my-usuario-opcion" 
                                                style="display: none;">
                                                <div class="my-opciones p-1 text-left">
                                                    <a title="Cerrar sesión" href="#">
                                                        <i class="fa fa-sign-out fa-sm p-1"></i> maxhugobueno@gmail.com
                                                    </a>
                                                </div>
                                            </div>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-2 centrar-custom">
                                <img class="my-img-per img-fluid" 
                                    src="<?php echo $ruta; ?>include/img/usuarioa.png" 
                                    alt="Usuario" title="Usuario">
                            </div>
                        </div>
                    </div>
                </div>
    </div>
</div>