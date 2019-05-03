<?php
session_name('sessionCetiAlumnoIntranet');
session_start();

if (!isset($_SESSION['USUARIO_ID'])){
    header("location: ". HOST);
}