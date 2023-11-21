<?php

namespace App\Controller\Admin;

use App\Entity\Discipline;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DisciplineCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        // Définir l'entité gérée par ce contrôleur CRUD
        return Discipline::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // Configuration des champs à afficher lors de l'édition de l'entité

        return [
            // Champ de texte pour le nom de la discipline
            TextField::new('name'),

            // Champ d'association pour lier un enseignant à la discipline
            AssociationField::new('teacher')
        ];
    }
}
