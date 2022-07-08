<?php

namespace App\Controller\Admin;

use App\Entity\Professor;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProfessorCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Professor::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('firstname'),
            TextField::new('lastname'),
            TextField::new('email'),
            TextField::new('password')->hideOnIndex(),
            ArrayField::new('roles'),
        ];
    }
}
