<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        // Définir l'entité gérée par ce contrôleur CRUD
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // Configuration des champs à afficher lors de l'édition de l'entité User

        return [
            // Champ de texte pour l'adresse e-mail de l'utilisateur
            EmailField::new('email'),

            // Champ de choix pour les rôles de l'utilisateur avec des options prédéfinies
            // Permet de choisir plusieurs rôles
            ChoiceField::new('roles')
                ->allowMultipleChoices()
                ->setChoices([
                    'Administrateur' => 'ROLE_ADMIN',
                    'Modérateur' => 'ROLE_MODO',
                    'Utilisateur' => 'ROLE_USER',
                ]),
        ];
    }
}
