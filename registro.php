<?php
    require 'partials/header.html';

?>        
        <main class="container">
            <div class="container-registro">
                <form method="post" id="form-registrarse">
                    <h1>Registrarse</h1>
                    <input type="email" id="reg-mail" class="textbox-general-abm" placeholder="I-mail" autocomplete="off" required>
                    <input type="text" id="reg-nombre" class="textbox-general-abm" placeholder="Nombre Apellido" autocomplete="off" required>
                    <input type="password" id="reg-pass" class="textbox-general-abm" placeholder="Contraseña" autocomplete="off" required>
                    <input type="password" id="reg-pass-con" class="textbox-general-abm" placeholder="Confirmar Contraseña" autocomplete="off" required>
                    <label id="error-regis"></label>
                    <div class="container-btn-login">
                        <input type="submit" class="btn-login" value="Crear Cuenta">
                        <a href="index.php">
                            <button type="button" class="btn-regitro">Volver</button> 
                        </a>
                    </div>
                </form>                
            </div>

        </main>
    </body>    
    <script src="assets/plugins/jquery-3.5.1.min.js"></script>
    <script src="assets/plugins/sweetalert2.all.min.js"></script>
    <script src="assets/scripts/registro.js"></script>
</html>