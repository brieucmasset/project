<?php
// CHARGEMENT DES LIBRAIRIES
require_once './lib/debug.php';
require_once './lib/format.php';
require_once './lib/route.php';

// CHARGEMENT DU MODÈLE
require_once './model/database.php';
require_once './model/products.php';
require_once './model/orders.php';

// SI ON A REÇU UN ID DANS L'URL
if (isset($_GET['id'])) {
    // ON RÉCUPÈRE CET ID
    $id = $_GET['id'];
} else {
    // SINON ON RETOURNE SUR LA PAGE D'ACCUEIL
    redirect('index.php');
}

// RÉCUPÈRE LE DÉTAIL DU PRODUIT
$product = getProduct($id);

// SI LE PRODUIT N'EXISTE PAS
if (empty($product)) {
    // SINON ON RETOURNE SUR LA PAGE D'ACCUEIL
    redirect('index.php');
}

// RÉCUPÈRE TOUTES LES COMMANDES DU PRODUIT
$orders = getOrdersByProductCode($id);

// CHARGEMENT DU TEMPLATE DE LA PAGE
include './templates/product.phtml';
