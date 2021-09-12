<?php

    session_start();

    if(!empty($_SESSION['id_usuario']))
    {
        require 'partials/header.html';
        require 'menu.php';
    }
    else
    {
        require 'partials/header.html';
        require 'login.php';
    }
?>