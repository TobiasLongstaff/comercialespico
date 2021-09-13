
        <main class="container">
            <div class="container-login">
                <form method="post" id="form-login">
                    <h1>Iniciar Sesión</h1>
                    <input type="text" id="log-mail" class="textbox-general-abm" placeholder="Usuario" ><br>
                    <input type="password" id="log-pass" class="textbox-general-abm" placeholder="Contraseña"><br>
                    <label id="error-login"></label>
                    <div class="container-btn-login">
                        <input type="submit" class="btn-login" value="Iniciar Sesión">
                        <a href="registro.php">
                            <button type="button" class="btn-regitro">Registrarse</button> 
                        </a>                        
                    </div>
                </form>                
            </div>
        </main>
    </body>
    <script src="assets/plugins/jquery-3.5.1.min.js"></script>
    <script src="assets/scripts/login.js"></script>
</html>