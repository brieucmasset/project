<?php
require_once './model/database.php';

/**
 * Renvoie la liste des meilleurs clients
 */
function getBestCustomers(): array
{

    // CONNECTION À LA BDD
    $database = connect();

    // CODE SQL À EXÉCUTER
    $SQL = 'SELECT `customers`.`customerNumber`, `customers`.`customerName`, ROUND(SUM(`orderdetails`.`quantityOrdered`* `orderdetails`.`priceEach`), 2) AS `CA`
            FROM `customers`
            JOIN `orders` ON `orders`.`customerNumber` = `customers`.`customerNumber`
            JOIN `orderdetails` ON `orderdetails`.`orderNumber` = `orders`.`orderNumber`
            GROUP BY `customers`.`customerNumber`
            ORDER BY `CA` DESC
            LIMIT 3;';

    // PRÉPARATION DE LA REQUÊTE
    $query = $database->prepare($SQL);

    // EXÉCUTION DE LA REQUÊTE
    $query->execute();

    // RÉCUPÉRATION DES DONNÉES DE LA REQUÊTE
    $datas = $query->fetchAll(PDO::FETCH_ASSOC);

    // RENVOIE LES DATAS FINALES
    return $datas;
}

/**
 * Renvoie les données du client précisé
 */
function getCustomer(int $customerNumber): array
{

    // CONNECTION À LA BDD
    $database = connect();

    // CODE SQL À EXÉCUTER
    // $SQL = 'SELECT *
    //        FROM `products`
    //        WHERE `productCode` = :productCode';
    $SQL = 'SELECT  `customers`.`customerNumber`, 
                    `customers`.`customerName`, 
                    `customers`.`contactLastName`, 
                    `customers`.`contactFirstName`, 
                    `customers`.`phone`, 
                    `customers`.`addressLine1`, 
                    `customers`.`addressLine2`, 
                    `customers`.`city`, 
                    `customers`.`state`, 
                    `customers`.`postalCode`, 
                    `customers`.`country`, 
                    `customers`.`salesRepEmployeeNumber`, 
                    `customers`.`creditLimit`, 
                    `employees`.`lastName`, 
                    `employees`.`firstName`, 
                    `employees`.`email`, 
                    `offices`.`city` as `officeCity`, 
                    `offices`.`country` as `officeCountry`,
                    ROUND(SUM(`orderdetails`.`quantityOrdered`* `orderdetails`.`priceEach`), 2) AS `CA`
            FROM `customers`
            JOIN `employees` ON `employees`.`employeeNumber` = `customers`.`salesRepEmployeeNumber`
            JOIN `offices` ON `offices`.`officeCode` = `employees`.`officeCode`
            JOIN `orders` ON `orders`.`customerNumber` = `customers`.`customerNumber`
            JOIN `orderdetails` ON `orderdetails`.`orderNumber` = `orders`.`orderNumber`
            WHERE `customers`.`customerNumber` = :customerNumber
            GROUP BY `customers`.`customerNumber`;';

    // PRÉPARATION DE LA REQUÊTE
    $query = $database->prepare($SQL);

    // EXÉCUTION DE LA REQUÊTE
    $query->execute([
        ':customerNumber' => $customerNumber
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
