<?php

use PHPUnit\Framework\TestCase;

class NavigationTest extends TestCase
{

    public function testIndex()
    {
        $client = new \GuzzleHttp\Client(); // Instanciation d'un client HTTP

        // On effectue une requête HTTP GET vers la page d'accueil
        $response = $client->request('GET', 'http://localhost/public/pokemon/');

        // On vérifie si la réponse est OK (code 200)
        $this->assertEquals(200, $response->getStatusCode());

        // On vérifie si le titre de la page contient le texte 'Pikachu'
        $body = $response->getBody()->getContents();
        $this->assertStringContainsString('Pikachu', $body);
    }
}
