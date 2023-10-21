<?php

namespace App\Controller\Admin;

use App\Entity\Store;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;

class StoreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Store::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Маркетплейс')
            ->setEntityLabelInPlural('Маркетплейсы');
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
            UrlField::new('link', 'Ссылка на маркетплейс')
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
            ,
        ];
    }

}
