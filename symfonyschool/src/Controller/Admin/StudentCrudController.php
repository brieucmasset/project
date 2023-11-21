<?php

namespace App\Controller\Admin;

use App\Entity\Student;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class StudentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        // Définir l'entité gérée par ce contrôleur CRUD
        return Student::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // Configuration des champs à afficher lors de l'édition de l'entité Student

        return [
            // Champ de texte pour le prénom de l'étudiant
            TextField::new('firstname'),

            // Champ de texte pour le nom de l'étudiant
            TextField::new('lastname'),

            // Champ entier pour l'âge de l'étudiant
            IntegerField::new('age'),

            // Champ de zone de texte pour l'adresse de l'étudiant
            TextareaField::new('address'),

            // Champ de texte pour le numéro de téléphone de l'étudiant
            TextField::new('phone'),

            // Champ de choix pour le sexe de l'étudiant avec des options prédéfinies
            ChoiceField::new('sexe')
                ->setChoices([
                    'homme' => 'Homme',
                    'femme' => 'Femme',
                    'no genre' => 'Non genré',
                ]),

            // Champ d'image pour la photo de l'étudiant
            ImageField::new('image')
                ->setBasePath('assets/data_user/')
                ->setUploadDir('public/assets/data_user/')
                ->setUploadedFileNamePattern('[year]_[month]_[day]_[slug]_[contenthash].[extension]')
        ];
    }
}
