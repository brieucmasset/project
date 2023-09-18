<?php
require_once './model/database.php';

/**
 *  Renvoie toutes les commandes contenant le produit spécifié
 */
function getOrdersByProductCode(string $productCode): array
{

    // CONNECTION À LA BDD
    $database = connect();

    // CODE SQL À EXÉCUTER
    $SQL = 'SELECT `orders`.`orderNumber`, 
                   `orders`.`orderDate`, 
                   `orders`.`customerNumber`, 
                   `customers`.`customerName`, 
                   `orderdetails`.`quantityOrdered`, 
                   `orderdetails`.`priceEach`, 
                   ROUND(`orderdetails`.`quantityOrdered` * `orderdetails`.`priceEach`, 2) AS `total`
            FROM `orders`
            JOIN `orderdetails` ON `orderdetails`.`orderNumber` = `orders`.`orderNumber`
            JOIN `customers` ON `customers`.`customerNumber` = `orders`.`customerNumber`
            WHERE `orderdetails`.`productCode` = :productCode
            ORDER BY `orders`.`orderDate` DESC;';

    // PRÉPARATION DE LA REQUÊTE
    $query = $database->prepare($SQL);

    // EXÉCUTION DE LA REQUÊTE
    $query->execute([
        ':productCode' => $productCode
    ]);

    // RÉCUPÉRATION DES DONNÉES DE LA REQUÊTE
    $datas = $query->fetchAll(PDO::FETCH_ASSOC);

    // RENVOIE LES DATAS FINALES
    return $datas;
}



/**
 *  Renvoie toutes les commandes d'un client spécifié
 */
function getOrdersByCustomerNumber(string $customerNumber): array
{

    // CONNECTION À LA BDD
    $database = connect();

    // CODE SQL À EXÉCUTER
    $SQL = 'SELECT  `orders`.`orderNumber`,  
                    `orders`.`orderDate`, 
                    `orders`.`requiredDate`, 
                    `orders`.`shippedDate`,
                    `orders`.`status`, 
                    SUM(`orderdetails`.`quantityOrdered`) AS `quantity`,
                    ROUND(SUM(`orderdetails`.`quantityOrdered` * `orderdetails`.`priceEach`), 2) AS `total`
            FROM `orders` 
            JOIN `orderdetails` ON `orderdetails`.`orderNumber` = `orders`.`orderNumber`
            WHERE `orders`.`customerNumber` = :customerNumber
            GROUP BY `orders`.`orderNumber`
            ORDER BY `orders`.`orderDate` DESC;';

    // PRÉPARATION DE LA REQUÊTE
    $query = $database->prepare($SQL);

    // EXÉCUTION DE LA REQUÊTE
    $query->execute([
        ':customerNumber' => $customerNumber
    ]);

    // RÉCUPÉRATION DES DONNÉES DE LA REQUÊTE
    $datas = $query->fetchAll(PDO::FETCH_ASSOC);

    // RENVOIE LES DATAS FINALES
    return $datas;
}


/**
 *  Renvoie toutes les commandes d'un client spécifié
 */
function getOrdersByEmployeNumber(string $employeNumber): array
{

    // CONNECTION À LA BDD
    $database = connect();

    // CODE SQL À EXÉCUTER
    $SQL = 'SELECT  `orders`.`orderNumber`,  
                    `orders`.`orderDate`,  
                    `orders`.`requiredDate`,  
                    `orders`.`shippedDate`,  
                    `orders`.`status`,  
                    `customers`.`customerNumber`,  
                    `customers`.`customerName`, 
            SUM(`orderdetails`.`quantityOrdered`) AS `quantity`,
            ROUND(SUM(`orderdetails`.`quantityOrdered` * `orderdetails`.`priceEach`), 2) AS `total`
            FROM `orders` 
            JOIN `customers` ON `customers`.`customerNumber` = `orders`.`customerNumber`
            JOIN `employees` ON `employees`.`employeeNumber` = `customers`.`salesRepEmployeeNumber`
            JOIN `orderdetails` ON `orderdetails`.`orderNumber` = `orders`.`orderNumber`
            WHERE `employees`.`employeeNumber` = :employeNumber
            GROUP BY `orders`.`orderNumber`
            ORDER BY `orders`.`orderDate` DESC;';

    // PRÉPARATION DE LA REQUÊTE
    $query = $database->prepare($SQL);

    // EXÉCUTION DE LA REQUÊTE
    $query->execute([
        ':employeNumber' => $employeNumber
    ]);

    // RÉCUPÉRATION DES DONNÉES DE LA REQUÊTE
    $datas = $query->fetchAll(PDO::FETCH_ASSOC);

    // RENVOIE LES DATAS FINALES
    return $datas;
}

/**
 * Renvoie le détail d'un commande
 */
function getOrder(string $orderNumber): array
{

    // CONNECTION À LA BDD
    $database = connect();

    // CODE SQL À EXÉCUTER
    $SQL = 'SELECT  `orders`.`orderNumber`, 
                    `orders`.`orderDate`, 
                    `orders`.`status`, 
                    `orders`.`comments`, 
                    `customers`.`customerName`, 
                    `customers`.`contactLastName`, 
                    `customers`.`contactFirstName`, 
                    `customers`.`phone`, `customers`.`addressLine1`, 
                    `customers`.`addressLine2`, 
                    `customers`.`postalCode`, 
                    `customers`.`city`, 
                    `customers`.`state`, 
                    `customers`.`country`, 
                    `customers`.`customerNumber`,
                    ROUND(SUM(`orderdetails`.`priceEach` * `orderdetails`.`quantityOrdered`), 2) as `total`
    FROM `orders` 
    JOIN `customers` ON `customers`.`customerNumber` = `orders`.`customerNumber`
    JOIN `orderdetails` ON `orderdetails`.`orderNumber` = `orders`.`orderNumber`
    WHERE `orders`.`orderNumber` = :orderNumber
    GROUP BY `orders`.`orderNumber`;';

    // PRÉPARATION DE LA REQUÊTE
    $query = $database->prepare($SQL);

    // EXÉCUTION DE LA REQUÊTE
    $query->execute([
        ':orderNumber' => $orderNumber
    ]);

    // RÉCUPÉRATION DES DONNÉES DE LA REQUÊTE
    $datas = $query->fetch(PDO::FETCH_ASSOC);

    // SI IL N'Y A PAS DE RÉSULTAT
    if ($datas === false) {

        // IL FAUT QUAND MÊME RENVOYER UN TABLEAU VIDE
        $datas = [];
    }

    // RENVOIE LES DATAS FINALES
    return $datas;
}

function getOrdersDetails(int $orderNumber): array
{

    // CONNECTION À LA BDD
    $database = connect();

    // CODE SQL À EXÉCUTER
    $SQL = 'SELECT  `orderdetails`.`productCode`,
                    `products`.`productName`,
                    `products`.`productLine`,
                    `products`.`productScale`, 
                    `orderdetails`.`quantityOrdered`, 
                    `orderdetails`.`priceEach`, 
    round(sum(`orderdetails`.`quantityOrdered` * `orderdetails`.`priceEach`),2) AS `Total` 
    FROM `orderdetails` 
    JOIN `products` ON `products`.`productCode` = `orderdetails`.`productCode`
    WHERE `orderdetails`.`orderNumber` = :orderNumber
    GROUP BY `products`.`productCode`;';

    // PRÉPARATION DE LA REQUÊTE
    $query = $database->prepare($SQL);

    // EXÉCUTION DE LA REQUÊTE
    $query->execute([
        ':orderNumber' => $orderNumber
    ]);

    // RÉCUPÉRATION DES DONNÉES DE LA REQUÊTE
    $datas = $query->fetchAll(PDO::FETCH_ASSOC);

    // RENVOIE LES DATAS FINALES
    return $datas;
}

function getOrderFull(int $orderNumber): array
{

    // CONNECTION À LA BDD
    $database = connect();

    // CODE SQL À EXÉCUTER
    $SQL = 'SELECT  `orders`.`orderNumber`, 
                    `orders`.`orderDate`, 
                    `orders`.`status`, 
                    `orders`.`comments`, 
                    `customers`.`customerName`, 
                    `customers`.`contactLastName`, 
                    `customers`.`contactFirstName`, 
                    `customers`.`phone`, `customers`.`addressLine1`, 
                    `customers`.`addressLine2`, 
                    `customers`.`postalCode`, 
                    `customers`.`city`, 
                    `customers`.`state`, 
                    `customers`.`country`, 
                    `customers`.`customerNumber`,
                    ROUND(SUM(`orderdetails`.`priceEach` * `orderdetails`.`quantityOrdered`), 2) as `total`
    FROM `orders` 
    JOIN `customers` ON `customers`.`customerNumber` = `orders`.`customerNumber`
    JOIN `orderdetails` ON `orderdetails`.`orderNumber` = `orders`.`orderNumber`
    WHERE `orders`.`orderNumber` = :orderNumber
    GROUP BY `orders`.`orderNumber`;';

    // PRÉPARATION DE LA REQUÊTE
    $query = $database->prepare($SQL);

    // EXÉCUTION DE LA REQUÊTE
    $query->execute([
        ':orderNumber' => $orderNumber
    ]);

    // RÉCUPÉRATION DES DONNÉES DE LA REQUÊTE
    $datas = $query->fetch(PDO::FETCH_ASSOC);

    // SI IL N'Y A PAS DE RÉSULTAT
    if ($datas === false) {

        // IL FAUT QUAND MÊME RENVOYER UN TABLEAU VIDE
        $datas = [];
    }

    // CODE SQL À EXÉCUTER
    $SQL = 'SELECT  `orderdetails`.`productCode`,
                    `products`.`productName`,
                    `products`.`productLine`,
                    `products`.`productScale`, 
                    `orderdetails`.`quantityOrdered`, 
                    `orderdetails`.`priceEach`, 
    round(sum(`orderdetails`.`quantityOrdered` * `orderdetails`.`priceEach`),2) AS `Total` 
    FROM `orderdetails` 
    JOIN `products` ON `products`.`productCode` = `orderdetails`.`productCode`
    WHERE `orderdetails`.`orderNumber` = :orderNumber
    GROUP BY `products`.`productCode`;';

    // PRÉPARATION DE LA REQUÊTE
    $query = $database->prepare($SQL);

    // EXÉCUTION DE LA REQUÊTE
    $query->execute([
        ':orderNumber' => $orderNumber
    ]);

    // RÉCUPÉRATION DES DONNÉES DE LA REQUÊTE
    $datas['lines'] = $query->fetchAll(PDO::FETCH_ASSOC);

    // RENVOIE LES DATAS FINALES
    return $datas;
}
