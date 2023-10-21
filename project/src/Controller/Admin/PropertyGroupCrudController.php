<?php

namespace App\Controller\Admin;

use App\Entity\PropertyGroup;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PropertyGroupCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PropertyGroup::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
