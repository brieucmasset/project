<?php
// CHARGEMENT DES LIBRAIRIES
require_once './lib/debug.php';
require_once './lib/format.php';
require_once './lib/route.php';

// CHARGEMENT DU MODÈLE
require_once './model/database.php';
require_once './model/customers.php';
require_once './model/orders.php';

// VÉRIFICATION SI UN ID A ÉTÉ REÇU DANS L'URL
if (isset($_GET['id'])) {
    // ON RÉCUPÈRE CET ID
    $id = $_GET['id'];
} else {
    // SI PAS D'ID, ON REDIRIGE VERS LA PAGE D'ACCUEIL
    redirect('index.php');
}

// CHARGE LES DONNÉES DU CLIENT EN UTILISANT L'ID RÉCUPÉRÉ
$customer = getCustomer($id);

// SI LE CLIENT N'EXISTE PAS
if(empty($customer)) {
    // SI CLIENT N'EXISTE PAS, REDIRECTION VERS LA PAGE D'ACCUEIL
    redirect('index.php');
}

// RÉCUPÉRATION DE TOUTES LES COMMANDES DU CLIENT EN UTILISANT L'ID DU CLIENT
$orders = getOrdersByCustomerNumber($id);

// CHARGEMENT DU TEMPLATE DE LA PAGE
include './templates/customer.phtml';
