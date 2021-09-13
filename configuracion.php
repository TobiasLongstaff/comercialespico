<?php

    session_start();

    if(empty($_SESSION['id_usuario']))
    {
        header("location: index.php");
    }
    else
    {
        require 'partials/header.html';
    }

?>  
        <main class="container-menu">
            <nav>
                <h1>Configuracion</h1>
                <div>
                    <a href="cerrarsesion.php">
                        <button type="button" class="btn-nav">
                            <i class="uil uil-sign-out-alt"></i>
                        </button>
                    </a> 
                </div>   
            </nav>
            <div class="container-general">
                <div class="container-archivos">
                    <div class="container-controles">
                        <a href="index.php">
                            <button type="button" class="btn-nueva-carpeta">
                                <i class="fas fa-chevron-left" aria-hidden="true"></i>
                            </button>                            
                        </a>
                    </div>
                    <div class="container-tabla-cliente" style="--delay: .5s">
                        <div class="container-tabla">
                            <table id="tabla">
                                <thead>
                                    <tr>
                                        <th class="columna-header columna-controles" colspan="2">
                                            <span>Controles</span>
                                        </th>  
                                        <th class="columna-header">
                                            <span>Id</span>    
                                        </th>
                                        <th class="columna-header">
                                            <span>Nombre</span>
                                        </th>
                                        <th class="columna-header">
                                            <span>Mail</span>
                                        </th>
                                    </tr>   
                                </thead>
                                <tbody id="container-cliente">       
                                </tbody>
                            </table>
                        </div>                    
                    </div>
                </div>
                <div class="cantainer-abm-clientes">
                    <h2>ABM Clientes</h2>
                    <form id="form-abm-clientes" method="POST">
                        <input type="hidden" id="id-cliente">
                        <input type="text" class="textbox-general-abm" id="nombre-cliente" placeholder="Nombre del cliente" required>
                        <input type="email" class="textbox-general-abm" id="mail-cliente" placeholder="Mail" required>
                        <input type="text" class="textbox-general-abm" id="password-cliente" placeholder="Contraseña" required>
                        <div class="container-btn-upload">
                            <input id="btn-agregar-nueva-cliente" type="submit" class="btn-enviar" value="Agregar">
                        </div>
                    </form>          
                </div>
            </div>
        </main>
    </body>    
    <script src="assets/plugins/jquery-3.5.1.min.js"></script>
    <script src="assets/plugins/sweetalert2.all.min.js"></script>
    <script src="assets/scripts/configuracion.js"></script>
</html>