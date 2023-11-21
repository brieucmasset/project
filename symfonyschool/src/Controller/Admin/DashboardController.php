<?php

namespace App\Controller\Admin;

use App\Entity\Classroom;
use App\Entity\Discipline;
use App\Entity\Student;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // Vous avez plusieurs options pour définir le comportement du tableau de bord.

        // Option 1 : Rediriger vers une page commune de votre backend
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ClassroomCrudController::class)->generateUrl());

        // Option 2 : Rediriger vers différentes pages en fonction de l'utilisateur
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3 : Rendre un modèle personnalisé pour afficher un tableau de bord approprié
        // (conseil : il est plus facile si votre modèle étend @EasyAdmin/page/content.html.twig)
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('SYMFONY SCHOOL'); // Définir le titre du tableau de bord
    }

    public function configureMenuItems(): iterable
    {
        // Configuration des éléments du menu du tableau de bord

        // Lien vers le tableau de bord lui-même
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        // Liens vers les pages de gestion (CRUD) pour différentes entités
        yield MenuItem::linkToCrud('Salle de cours', 'fas fa-list', Classroom::class);
        yield MenuItem::linkToCrud('Discipline', 'fas fa-list', Discipline::class);
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('Etudiant', 'fas fa-list', Student::class);
    }
}
