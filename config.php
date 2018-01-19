<?php
/**
 * by @rivelbab on kali linux 2017 at Paris
 */
/* Paramettre de connexion a la base de donnees */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'demo');

/* connexion a la base de donnees */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// verification de la connexion
if($link === false){
    die("ERROR: impossible de se connecter. " . mysqli_connect_error());
}
?>
