<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        // Retourne la classe de l'entité gérée par ce contrôleur
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // Choix possibles pour le champ "roles"
        $rolesChoices = [
            'ROLE_USER' => 'ROLE_USER',
            'ROLE_ADMIN' => 'ROLE_ADMIN',
        ];

        // Retournez un tableau de champs à afficher
        return [
            IdField::new('id')
                ->onlyOnIndex(), // Champ d'ID visible uniquement dans la liste
            TextField::new('username'), // Champ pour le nom d'utilisateur
            ChoiceField::new('roles')
                ->setChoices($rolesChoices) // Définir les choix possibles pour les rôles
                ->allowMultipleChoices() // Permettre le choix de plusieurs rôles
                ->setRequired(true), // Rendre le champ obligatoire
            TextField::new('password'), // Champ pour le mot de passe
            TextField::new('name'), // Champ pour le nom
            TextField::new('email'), // Champ pour l'adresse e-mail
        ];
    }
}
