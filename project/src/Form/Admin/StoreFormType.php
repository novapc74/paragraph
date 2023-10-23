<?php

namespace App\Form\Admin;

use App\Entity\Store;
use App\Repository\StoreRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StoreFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('link', UrlType::class, [
                'label' => 'Ссылка',
            ])
            ->add('title', ChoiceType::class, [
                'label' => 'Маркет',
                'choices' => [
                    'OZONE' => 'ozone',
                    'WILDBERRIES' => 'wb'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Store::class,
        ]);
    }
}
