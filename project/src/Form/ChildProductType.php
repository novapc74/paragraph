<?php

namespace App\Form;

use App\Entity\Color;
use App\Entity\Gallery;
use App\Entity\Product;
use App\Entity\ProductModification;
use App\Form\Admin\GalleryType;
use App\Form\Admin\MediaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChildProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sku', TextType::class, [
                'label' => 'Артикул',
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
