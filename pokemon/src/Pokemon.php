<?php

namespace Src;

abstract class Pokemon
{

    // Initialisation des variables
    protected string $name; // Nom du Pokémon
    protected int $pv; // Valeur des points de vie
    protected int $pa; // Valeur maximale des points d'attaque
    protected int $pd; // Valeur maximale des points de défense
    protected int $niveau; // Niveau du Pokémon
    protected string $image; // Chemin de l'image du Pokémon

    /**
     * Constructeur de la classe
     * 
     * @param string $name Nom du Pokémon
     * @param int $pv Valeur des points de vie
     * @param int $pa Valeur maximale des points d'attaque
     * @param int $pd Valeur maximale des points de défense
     * @param int $niveau Niveau du Pokémon
     * @param string $image Chemin de l'image du Pokémon
     */
    public function __construct($name, $pv, $pa, $pd, $niveau, $image)
    {
        $this->name = $name;
        $this->pv = $pv;
        $this->pa = $pa;
        $this->pd = $pd;
        $this->niveau = $niveau;
        $this->image = $image;

        $this->presentation();
    }

    /**
     * Getter pour le nom du Pokémon
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Getter pour les points de vie du Pokémon
     */
    public function getPv(): int
    {
        return $this->pv;
    }

    /**
     * Setter pour les points de vie du Pokémon
     */
    public function setPv(int $pv)
    {
        $this->pv = $pv;
    }

    /**
     * Getter pour les points d'attaque du Pokémon
     */
    public function getPa(): int
    {
        return $this->pa;
    }

    /**
     * Setter pour les points d'attaque du Pokémon
     */
    public function setPa(int $pa)
    {
        $this->pa = $pa;
    }

    /**
     * Getter pour les points de défense du Pokémon
     */
    public function getPd(): int
    {
        return $this->pd;
    }

    /**
     * Setter pour les points de défense du Pokémon
     */
    public function setPd(int $pd)
    {
        $this->pd = $pd;
    }

    /**
     * Getter pour le niveau du Pokémon
     */
    public function getNiveau(): int
    {
        return $this->niveau;
    }

    /**
     * Setter pour le niveau du Pokémon
     */
    public function setNiveau(int $niveau)
    {
        $this->niveau = $niveau;
    }

    /**
     * Méthode d'attaque du Pokémon
     */
    public function attaque(Pokemon $adversaire): void
    {
        $nbPa = rand(1, $this->pa); // Génère un nombre aléatoire entre 1 et la valeur maximale des points d'attaque
        $adversaire->setPv($adversaire->getPv() - $nbPa); // Réduit les points de vie de l'adversaire

        echo $this->name . ' a attaqué ' . $adversaire->getName() . ', il lui a infligé ' . $nbPa . ' point(s) de dégats.<br />' . $adversaire->getName() . ' a maintenant ' . $adversaire->getPv() . ' point(s) de vie.<br />';

        if ($adversaire->getPV() <= 0) {
            $adversaire->mort();
        }
    }

    /**
     * Méthode pour soigner le Pokémon
     */
    public function soigner(): void
    {
        $nbPa = rand(1, $this->pa); // Génère un nombre aléatoire entre 1 et la valeur maximale des points d'attaque
        $this->setPv($this->getPv() + $nbPa); // Ajoute des points de vie au Pokémon

        echo $this->name . ' s\'est soigné et a repris ' . $nbPa . ' point(s) de vie.<br />';
    }

    /**
     * Méthode privée appelée lorsque le Pokémon meurt
     */
    private function mort()
    {
        echo $this->name . ' est mort.<br />';
    }

    /**
     * Méthode pour présenter le Pokémon
     */
    public function presentation()
    {
        echo '<table class="table">';
        echo '<tr>';
        echo '<td>';
        echo 'Nom du Pokemon :';
        echo '</td>';
        echo '<td>';
        echo $this->name;
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>';
        echo 'Type :';
        echo '</td>';
        echo '<td>';
        echo explode('\\', get_class($this))[2]; // Obtient le nom de la classe sans le namespace
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>';
        echo 'Point de vie :';
        echo '</td>';
        echo '<td>';
        echo $this->pv;
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>';
        echo 'Point d\'attaque :';
        echo '</td>';
        echo '<td>';
        echo $this->pa;
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>';
        echo 'Point de défense :';
        echo '</td>';
        echo '<td>';
        echo $this->pd;
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td>';
        echo 'Generation :';
        echo '</td>';
        echo '<td>';
        echo $this->niveau;
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan="2">';
        echo '<img src="' . $this->image . '" />';
        echo '</td>';
        echo '</tr>';
        echo '</table>';
    }
}
