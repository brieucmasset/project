<?php
require_once './model/database.php';

/**
 * Renvoie la liste des produits presque épuisés
 */
function getOutOfStockProducts(): array
{

    // CONNECTION À LA BDD
    $database = connect();

    // CODE SQL À EXÉCUTER
    $SQL = 'SELECT `productCode`, 
                   `productName`, 
                   `productLine`, 
                   `productScale`, 
                   `quantityInStock`
            FROM `products` 
            WHERE `quantityInStock` <= 200;';

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
 * Renvoie la liste des meilleures ventes
 */
function getBestSellersProducts(): array
{

    // CONNECTION À LA BDD
    $database = connect();

    // CODE SQL À EXÉCUTER
    $SQL = 'SELECT `products`.`productCode`, 
                   `products`.`productName`, 
                   SUM(`orderdetails`.`quantityOrdered`) AS `quantity`
            FROM `products`
            JOIN `orderdetails` ON `orderdetails`.`productCode` = `products`.`productCode`
            GROUP BY `products`.`productCode`
            ORDER BY `quantity` DESC
            LIMIT 20';

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
 * Renvoie le nombre de produit dans chaque catégorie de produits 
 */
function getNumberOfProductsByProductLines()
{

    // CONNECTION À LA BDD
    $database = connect();

    // CODE SQL À EXÉCUTER
    $SQL = 'SELECT `productLine`, COUNT(*) AS `quantity`
            FROM `products`
            GROUP BY  `productLine`;';

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
 * Renvoie le détail du produit spécifié
 */
function getProduct(string $productCode): array
{

    // CONNECTION À LA BDD
    $database = connect();

    // CODE SQL À EXÉCUTER
    $SQL = 'SELECT *
            FROM `products`
            WHERE `productCode` = :productCode';

    // PRÉPARATION DE LA REQUÊTE
    $query = $database->prepare($SQL);

    // EXÉCUTION DE LA REQUÊTE
    $query->execute([
        ':productCode' => $productCode
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
