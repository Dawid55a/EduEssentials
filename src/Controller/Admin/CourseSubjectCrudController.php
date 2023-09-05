<?php

namespace App\Controller\Admin;

use App\Entity\CourseSubject;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class CourseSubjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CourseSubject::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setDefaultSort(['course' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->onlyOnIndex(),
            AssociationField::new('course'),
            AssociationField::new('subject'),
            AssociationField::new('teacher')
        ];
    }

}
