<?php

namespace Src;

class Utility{

    /**
     * Fonction mrPropre
     * 
     * Cette fonction remplace les caractères spécifiques dans une chaîne de caractères
     */
    public function mrPropre($word){
        // Le caractère à rechercher
        $search = ['É'];

        // Le caractère de remplacement
        $replace = ['E'];

        // On utilise la fonction str_replace pour remplacer les caractères spécifiés
        $cleanWord = str_replace($search, $replace, $word);

        // Retourne le mot ou la phrase nettoyé
        return $cleanWord;
    }

}
