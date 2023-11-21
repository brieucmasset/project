<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    // Injection de RequestStack pour gérer les sessions
    public function __construct(private RequestStack $requestStack) {
    }

    // Page d'accueil
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // Accès à l'objet général qui gère les sessions
        $session = $this->requestStack->getSession();

        // Attribution d'une clé et d'une valeur dans la session
        $session->set('name', 'Brieuc');

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
