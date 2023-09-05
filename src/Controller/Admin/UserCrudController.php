<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $roles = ['ROLE_ADMIN', 'ROLE_STUDENT', 'ROLE_TEACHER'];
        return [
            IdField::new('id')
                ->onlyOnIndex(),
            EmailField::new('email'),
            TextField::new('first_name')
                ->onlyOnForms(),
            TextField::new('last_name')
                ->onlyOnForms(),
            TextField::new('fullName')
                ->onlyOnIndex(),
            TextField::new('address'),
            TextField::new('phone_number'),
            DateField::new('date_of_birth'),
            ChoiceField::new('roles')
                ->setChoices(['Admin' => 'ROLE_ADMIN', 'Student' => 'ROLE_STUDENT', 'Teacher' => 'ROLE_TEACHER'])
                ->allowMultipleChoices()
                ->renderExpanded()
        ];
    }

}
