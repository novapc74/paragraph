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
    public function __construct(private readonly StoreRepository $repository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $choices = array_map(fn(Store $store) => $store->getTitle(), $this->repository->findAll());

        $builder
            ->add('link', UrlType::class, [
                'label' => 'Ссылка на товар',
            ])
            ->add('title', ChoiceType::class, [
                'label' => 'Маркетплейсы',
                'choices' => array_unique($choices),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Store::class,
        ]);
    }
}
