<?php

// Récupération de la liste des Pokémon à partir de l'API
$list = file_get_contents('https://pokebuildapi.fr/api/v1/pokemon');
$list = json_decode($list);

// Initialisation d'une variable pour stocker le code HTML généré
$string = '';

// Parcours de la liste des Pokémon
foreach ($list as $row) {
    // Construction du code HTML pour chaque Pokémon
    $string .= '<div class="col-3">';
    $string .= '<input type="checkbox" name="pokemon[]" value="' . $row->id . '">';
    $string .= '<a href="details.php?id=' . $row->id . '">';
    $string .= '<img style="width:70px;" src="' . $row->image . '" /><br />';
    $string .= $row->name;
    $string .= '</a>';
    $string .= '</div>';
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokemon - Acceuil</title>
    <link rel="icon" href="./assets/png/pokeball.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<!--NAVBAR-->
<nav class="navbar" style="background-color: #f5f5f5;">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="./assets/png/pokemon-logo.png" alt="logo" width="80" height="70">
        </a>
    </div>
</nav>

<body>
    <form action="simulation.php" method="POST">
        <div class="container">
            <div class="row">
                <?php echo $string; ?>
                <input type="submit" value="Lancer le combat" class="form-control">
            </div>
        </div>
    </form>
</body>

</html>