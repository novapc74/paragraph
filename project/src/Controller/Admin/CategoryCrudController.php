<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Country;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
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
            ->setEntityLabelInSingular('Категория')
            ->setPageTitle('new', 'Добавить категорию')
            ->setPageTitle('edit', fn(Category $category) => sprintf('Редактировать категорию: " %s "', $category->getTitle()))
            ->setEntityLabelInPlural('Категории');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Основное'),
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
            FormField::addTab('Продукты'),
            AssociationField::new('products', 'Продукты')
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-4')
                ->setFormTypeOption('by_reference', false)
                ->setQueryBuilder(fn(QueryBuilder $queryBuilder) => $queryBuilder->where('entity.parentProduct is null'))
                ->setTemplatePath('admin/crud/assoc_description.html.twig')
            ,
        ];
    }
}
