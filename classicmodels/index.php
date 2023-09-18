<?php
// CHARGEMENT DES LIBRAIRIES
require_once './lib/debug.php';
require_once './lib/format.php';

// CHARGEMENT DU MODEL
require_once './model/database.php';
require_once './model/products.php';
require_once './model/customers.php';
require_once './model/employees.php';

// CHARGEMENT DES DONNÉES EN PROVENANCE DU MODEL
$outOfStock = getOutOfStockProducts();        // Produits hors stock
$bestSellers = getBestSellersProducts();      // Meilleures ventes
$bestCustomers = getBestCustomers();          // Meilleurs clients
$bestEmployees = getBestEmployees();          // Meilleurs employés
$productLines = getNumberOfProductsByProductLines();  // Nombre de produits par ligne de produit

// CHARGEMENT DU TEMPLATE DE LA PAGE
include './templates/index.phtml';
