<?php

namespace App\Form\Admin;

use App\Entity\Color;
use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ChildProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sku', TextType::class, [
                'label' => 'Артикул',
                'constraints' => [
                    new NotBlank()
                ],
                'error_bubbling' => false,
            ])
            ->add('color', EntityType::class, [
                'label' => 'Цвет',
                'class' => Color::class,
            ])
            ->add('gallery', CollectionType::class, [
                'label' => 'Галерея',
                'allow_add' => true,
                'allow_delete' => true,
                'entry_type' => GalleryType::class,
                'by_reference' => false,
                'mapped' => true,
            ])
            ->add('marketPlaces', CollectionType::class, [
                'label' => 'Маркетплейсы',
                'entry_type' => MarketPlaceFormType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'mapped' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
