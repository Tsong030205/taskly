<?php
function db_connect() {
    $host = 'localhost';
    $dbname = 'taskfly';
    $user = 'root';
    $password = '';

    //On essaie de se connecter
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $conn;
    } catch (PDOException $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        echo "Erreur : " .$e->getMessage();
    }
}