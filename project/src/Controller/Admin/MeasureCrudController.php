<?php

namespace App\Controller\Admin;

use App\Entity\Measure;
use App\Entity\Property;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MeasureCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Measure::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Меру')
            ->setPageTitle('new', 'Новая мера')
            ->setPageTitle('edit', fn(Measure $measure) => sprintf('Редактировать меру: " %s "', $measure->getTitle()))
            ->setEntityLabelInPlural('Меры измерения');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Название')
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
            ,
            FormField::addRow(),
            TextField::new('value', 'Отображение')
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
            ,
        ];
    }
}
