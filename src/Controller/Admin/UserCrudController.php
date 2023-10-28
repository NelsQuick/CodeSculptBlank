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
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $rolesChoices = [
            'ROLE_USER' => 'ROLE_USER',
            'ROLE_ADMIN' => 'ROLE_ADMIN',
        ];
    
        return [
            IdField::new('id')
                ->onlyOnIndex(),
            TextField::new('username'),
            ChoiceField::new('roles')
                ->setChoices($rolesChoices)
                ->allowMultipleChoices() // Si vous voulez autoriser plusieurs rôles
                ->setRequired(true), // Si vous voulez rendre ce champ obligatoire
            TextField::new('password'),
            TextField::new('name'),
            TextField::new('email'),
        ];
    }
}
