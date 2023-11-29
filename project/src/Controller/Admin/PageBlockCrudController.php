<?php

namespace App\Controller\Admin;

use App\Entity\PageBlock;
use App\Entity\Product;
use App\Form\Admin\MediaType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Validator\Constraints\NotBlank;

class PageBlockCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PageBlock::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Блок')
            ->setPageTitle('new', 'Новый блок')
            ->setPageTitle('edit', fn(PageBlock $pageBlock) => sprintf('Редактировать блок: " %s "', PageBlock::getAvailableType($pageBlock->getType())))
            ->setEntityLabelInPlural('Блоки');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ChoiceField::new('type', 'Тип блока')
                ->setChoices(PageBlock::getAvailableType())
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
            ,
//            FormField::addRow(),
//            TextField::new('title')
//                ->setTextAlign('center')
//                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
//            ,
            FormField::addRow(),
            TextareaField::new('text', 'Текст')
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
            ,
//            FormField::addRow(),
//            TextareaField::new('html')
//                ->setFormType(CKEditorType::class)
//                ->setTextAlign('center')
//                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
//            ,
            FormField::addRow(),
            AssociationField::new('product', 'Продукт')
                ->setTextAlign('center')
            ->setHelp('Для блока <span style="color: red">"ИНТЕРЬЕР"</span> продукты не нужны.')
            ,
            FormField::addRow(),
            TextField::new('newImage', 'Картинка')
                ->onlyOnIndex()
                ->setTemplatePath('admin/crud/assoc_image.html.twig')
            ,
            FormField::addPanel('Картинка')
                ->setProperty('newImage')
                ->setFormType(MediaType::class)
                ->setFormTypeOptions([
                    'by_reference' => false,
                    'error_bubbling' => false,
                    'mapped' => true,
                    'constraints' => [
                        new NotBlank(),
                    ]
                ])
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
                ->onlyOnForms()
            ,
        ];
    }
}
