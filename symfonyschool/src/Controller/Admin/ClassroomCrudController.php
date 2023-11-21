<?php

namespace App\Controller\Admin;

use App\Entity\Classroom;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ClassroomCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Classroom::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // Champ de texte pour le nom de la salle de classe
            TextField::new('name'),

            // Champ entier pour la capacité de la salle de classe
            IntegerField::new('capacity'),

            // Champ d'association pour lier des enseignants à la salle de classe
            AssociationField::new('teachers')
        ];
    }
}
