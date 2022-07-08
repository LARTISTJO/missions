<?php

namespace App\Controller\Admin;

use App\Entity\Studies;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class StudiesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Studies::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextEditorField::new('description'),
            ImageField::new('image')->setUploadDir("/public/images/uploads")
                ->setBasePath("/images/uploads")
                ->setRequired(false),
            AssociationField::new('studycreator'),
            AssociationField::new('studytheme'),
        ];
    }

}
