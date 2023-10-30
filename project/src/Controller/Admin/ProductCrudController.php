<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\Admin\GalleryType;
use App\Form\Admin\ProductPropertyValueType;
use App\Form\Admin\StoreFormType;
use App\Form\ChildProductType;
use App\Form\ProductModificationType;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Gedmo\Tree\RepositoryInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Товар')
            ->setPageTitle('new', 'Новый товар')
            ->setPageTitle('edit', fn(Product $product) => sprintf('Редактировать товар: " %s "', $product->getTitle()))
            ->setEntityLabelInPlural('Товары');
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
            FormField::addRow(),
            TextField::new('sku', 'Артикул')
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
            ,
            FormField::addRow(),
            TextareaField::new('shortDescription', 'Короткое описание')
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
                ->setFormTypeOptions([
                    'constraints' => [
                        new NotBlank(),
                    ]
                ])
            ,
            FormField::addRow(),
            TextareaField::new('fullDescription', 'Полное описание')
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
                ->setFormTypeOptions([
                    'constraints' => [
                        new NotBlank(),
                    ]
                ])
            ,
            FormField::addTab('Свойства товара'),
            CollectionField::new('productProperties', 'Свойства товара')
                ->setEntryType(ProductPropertyValueType::class)
                ->setTemplatePath('admin/crud/assoc_description.html.twig')
                ->setTextAlign('center')
                ->renderExpanded()
            ,
            FormField::addTab('Маркетплейс'),
            CollectionField::new('marketPlaces', 'Маркетплейсы')
                ->setEntryType(StoreFormType::class)
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'error_bubbling' => false,
                ])
                ->setTextAlign('center')
                ->renderExpanded()
            ,
            FormField::addTab('Галерея'),
            CollectionField::new('gallery', 'Галерея')
                ->setEntryType(GalleryType::class)
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'error_bubbling' => false,
                ])
                ->renderExpanded()
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
                ->setTemplatePath('admin/crud/assoc_gallery.html.twig')
            ,
            FormField::addTab('Модификации'),
            CollectionField::new('childProducts', 'Модификации')
                ->setEntryType(ChildProductType::class)
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'error_bubbling' => false,
                ])
                ->setTemplatePath('admin/crud/assoc_description.html.twig')
        ];
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        return parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters)
            ->where('entity.parentProduct is null');
    }
}
