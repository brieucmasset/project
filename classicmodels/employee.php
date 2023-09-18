<?php
// CHARGEMENT DES LIBRAIRIES
require_once './lib/debug.php';
require_once './lib/format.php';
require_once './lib/route.php';

// CHARGEMENT DU MODÈLE
require_once './model/database.php';
require_once './model/customers.php';
require_once './model/orders.php';
require_once './model/employees.php';

// VÉRIFICATION SI UN ID A ÉTÉ REÇU DANS L'URL
if (isset($_GET['id'])) {
    // ON RÉCUPÈRE CET ID
    $id = $_GET['id'];
} else {
    // SINON, REDIRECTION VERS LA PAGE D'ACCUEIL
    redirect('index.php');
}

// CHARGE LES DONNÉES DE L'EMPLOYÉ
$employee = getEmployee($id);

// SI L'EMPLOYÉ N'EXISTE PAS
if (empty($employee)) {
    // ON RETOURNE SUR LA PAGE D'ACCUEIL
    redirect('index.php');
}

// RÉCUPÉRATION DU CHEF DE L'EMPLOYÉ
$boss = getEmployee($employee['reportsTo']);

// RÉCUPÉRATION DES COMMANDES DE L'EMPLOYÉ
$orders = getOrdersByEmployeNumber($employee['employeeNumber']);

// CHARGEMENT DU TEMPLATE DE LA PAGE
include './templates/employee.phtml';
