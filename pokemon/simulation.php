<?php

use Src\Api;
use Src\Pokemons\Feu;

include_once './vendor/autoload.php';

if(isset($_POST['pokemon'])){
    $pokemons = $_POST['pokemon'];
}else{
    header('Location:index.php');
}

$combattant1 = $pokemons[0];
$combattant2 = $pokemons[1];

// Création d'une instance de la classe Api
$api = new Api();

// Récupération des objets Pokémon à partir de leurs identifiants
$combattant1 = $api->getPokemonId($combattant1);
$combattant2 = $api->getPokemonId($combattant2);

// Combat entre les deux combattants
$combattant1->attaque($combattant2);
$combattant2->attaque($combattant1);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokemon - Combat</title>
    <link rel="icon" href="./assets/png/pokeball.png" type="image/x-icon">
</head>
<body>
    
</body>
</html>