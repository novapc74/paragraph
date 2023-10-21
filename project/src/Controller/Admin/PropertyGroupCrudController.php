<?php

namespace App\Controller\Admin;

use App\Entity\PropertyGroup;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PropertyGroupCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PropertyGroup::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Группу')
            ->setPageTitle('new', 'Новая группа')
            ->setPageTitle('edit', fn(PropertyGroup $propertyGroup) => sprintf('Редактировать группу: " %s "', $propertyGroup->getTitle()))
            ->setEntityLabelInPlural('Группы');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Название')
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
            ,
            FormField::addRow(),
            SlugField::new('slug', 'Идентификатор')
                ->setTargetFieldName('title')
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
            ,
            FormField::addRow(),
            IntegerField::new('position', 'Позиция')
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
            ,
        ];
    }
}
