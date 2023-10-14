<?php

namespace App\Controller\Admin;

use App\Entity\Review;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ReviewCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Review::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Отзыв')
            ->setEntityLabelInPlural('Отзывы');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('subTitle', 'Заголовок')
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
            ,
            FormField::addRow(),
            TextField::new('title', 'Имя')
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
            ,
            FormField::addRow(),
            TextareaField::new('description', '')
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
            ,
            FormField::addRow(),
            IntegerField::new('rating', 'Рейтинг')
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
                ->setFormTypeOptions([
                    'constraints' => [
                        new Callback([
                            $this,
                            'validate'
                        ])
                    ],
                    'error_bubbling' => false,
                ])
        ];
    }

    public function validate($rating, ExecutionContextInterface $context): void
    {
        if ($rating && !in_array($rating, range(1, 5))) {
            $context
                ->buildViolation(sprintf('Значение рейтинка "%s" должно находится в интервале от 1 до 5', $rating))
                ->atPath('rating')
                ->addViolation();
        }
    }
}
