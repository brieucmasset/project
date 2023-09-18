<?php

namespace Src;

use Src\Utility;

class Api
{

    /**
     * Méthode pour récupérer un Pokémon en fonction de son ID
     */
    public function getPokemonId($id)
    {
        $utility = new Utility(); // Instanciation de la classe Utility

        // Appel de l'API pour récupérer les informations des Pokémons
        $obj = file_get_contents('https://pokebuildapi.fr/api/v1/pokemon/' . $id);

        // Transformation de la réponse de l'API en objet JSON
        $obj = json_decode($obj);

        // Appel de la fonction mrPropre et récupération du type de Pokémon dans l'objet
        $type = $utility->mrPropre($obj->apiTypes[0]->name);

        // Instanciation de la classe du Pokémon correspondant au type récupéré
        // Le nom de la classe est dynamiquement construit en fonction du type
        $className = "Src\\Pokemons\\$type";
        return new $className(
            $obj->name,
            $obj->stats->HP,
            $obj->stats->attack,
            $obj->stats->defense,
            $obj->apiGeneration,
            $obj->image
        );
    }
}
