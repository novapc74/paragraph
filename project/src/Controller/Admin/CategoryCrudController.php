<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Color;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Категорию')
            ->setPageTitle('new', 'Добавить категорию')
            ->setPageTitle('edit', fn(Category $category) => sprintf('Редактировать категорию: " %s "', $category->getTitle()))
            ->setEntityLabelInPlural('Категории товаров');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Категория')
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
