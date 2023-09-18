<?php


/**
 * Crée une connexion à la BDD
 */
function connect()
{
    // TENTATIVE DE CONNEXION À LA BDD
    $dsn = 'mysql:dbname=classicmodels;host=127.0.0.1';
    $user = 'root';
    $password = 'root';
    $database = new PDO($dsn, $user, $password);

    return $database;
}
