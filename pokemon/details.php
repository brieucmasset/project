<?php

use Src\Utility;
use Utility as GlobalUtility;

// Inclusion de l'autoloader de Composer
include_once './vendor/autoload.php';

// Récupération de l'ID dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    // Redirection vers la page d'accueil si l'ID n'est pas présent
    header('Location:index.php');
}

// Appel de l'API pour récupérer les données du Pokémon
$obj = file_get_contents('https://pokebuildapi.fr/api/v1/pokemon/' . $id);

// Transformation de la chaîne de caractères en JSON
$obj = json_decode($obj);

// Récupération du type de Pokémon dans l'objet
$utility = new Utility();
$type = $utility->mrPropre($obj->apiTypes[0]->name);

// Instanciation de la classe correspondante au type du Pokémon
$className = "Src\\Pokemons\\$type";
$var = new $className(
    $obj->name,
    $obj->stats->HP,
    $obj->stats->attack,
    $obj->stats->defense,
    $obj->apiGeneration,
    $obj->image
);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokemon - Détails</title>
    <link rel="icon" href="./assets/png/pokeball.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>

</body>

</html>