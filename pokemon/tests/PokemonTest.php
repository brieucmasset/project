<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

// Classe de test
final class PokemonTest extends TestCase
{
    // Test d'exemple pour saluer avec un nom
    public function testGreetsWithName(): void
    {
        $greeting = 'Hello, Alice!';

        // Test d'égalité de texte
        $this->assertSame('Hello, Alice!', $greeting);
    }

    // Fournisseur de données pour les tests d'addition
    public static function additionProvider(): array
    {
        return [
            [0, 0, 0],
            [0, 1, 1],
            [1, 0, 1],
            [1, 1, 2],
        ];
    }

    // Test d'addition avec des données fournies par le DataProvider
    #[DataProvider('additionProvider')]
    public function testAdd(int $a, int $b, int $expected): void
    {
        $this->assertSame($expected, $a + $b);
    }

    // Test d'instanciation d'un Pokémon
    public function testInstanciate(): void
    {
        $pokemon = new \Src\Pokemons\Eau('toto', 10, 10, 10, 2, '');
        $name = $pokemon->getName();

        $this->assertSame('toto', $name);
        $this->assertEquals(10, $pokemon->getPv());
    }

    // Test pour vérifier si l'objet a les propriétés attendues
    public function testIsPropertyExist()
    {
        $pokemon = new \Src\Pokemons\Eau('toto', 10, 10, 10, 2, '');

        $this->assertObjectHasProperty('name', $pokemon);
        $this->assertObjectHasProperty('pa', $pokemon);
        $this->assertObjectHasProperty('pv', $pokemon);
        $this->assertObjectHasProperty('pd', $pokemon);
    }
}
