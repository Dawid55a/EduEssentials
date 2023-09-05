<?php

namespace App\Controller\Admin;

use App\DTO\TestStatusEnum;
use App\Entity\Test;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TestCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Test::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->onlyOnIndex(),
            TextField::new('name'),
            AssociationField::new('course_subject'),
            AssociationField::new('teacher'),
            CollectionField::new('grades'),
            IntegerField::new('weight'),
            ChoiceField::new('status')
                ->setChoices(TestStatusEnum::cases())
                ->setFormTypeOptions([
                    'choices' => TestStatusEnum::getChoices(),
                ])
        ];
    }

}
