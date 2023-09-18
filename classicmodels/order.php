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
    // SINON, REDIRECTION VERS LA PAGE D'ACCUEIL
    redirect('index.php');
}

// CHARGEMENT DES DONNÉES DE LA COMMANDE
$order = getOrder($id);

// SI LA COMMANDE N'EXISTE PAS
if (empty($order)) {
    // REDIRECTION VERS LA PAGE D'ACCUEIL
    redirect('index.php');
}

// RÉCUPÉRATION DE TOUTES LES LIGNES DE LA COMMANDE
$orderDetails = getOrdersDetails($id);

// CHARGEMENT DU TEMPLATE DE LA PAGE
include './templates/order.phtml';
