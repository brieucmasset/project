<?php

/**
 * Fonction de debug
 */
function debug(mixed $var, string $text = ''): void
{

    // AFFICHE UN TABLEAU OU UN OBJET
    if (is_array($var) ||  is_object($var)) {
        if ($text) {
            echo $text . ' : ' . '<br>';
        }

        echo '<pre>';
        print_r($var);
        echo '</pre>';
    } else {

        // GESTION DES BOOLÉENS
        if ($var === true) {
            $var = ('true');
        }
        if ($var === false) {
            $var = ('false');
        }

        // AFFICHE JUSTE UNE SIMPLE VARIABLE
        if ($text) {
            echo $text . ' : ' . $var . '<br>';
        } else {
            echo $var . '<br>';
        }
    }
}

/**
 * Shorhand vers la fonction de debug
 */
function d(mixed $var, string $text = ''): void
{
    debug($var, $text);
}
