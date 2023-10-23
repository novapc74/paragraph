<?php

namespace App\Form\Admin;

use App\Entity\Country;
use App\Entity\Measure;
use App\Entity\ProductPropertyValue;
use App\Entity\Property;
use App\Repository\CountryRepository;
use App\Repository\MeasureRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductPropertyValueType extends AbstractType
{
    public function __construct(private readonly CountryRepository $countryRepository,
                                private readonly MeasureRepository $measureRepository)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $countryChoices = [];
        array_map(
            function (Country $country) use (&$countryChoices) {
                $countryChoices[$country->getTitle()] = $country->getTitle();
            },
            $this->countryRepository->findAll()
        );

        $measureChoices = [];
        array_map(
            function (Measure $measure) use (&$measureChoices) {
                $measureChoices[$measure->getTitle()] = $measure->getValue();
            },
            $this->measureRepository->findAll()
        );

        $builder
            ->add('productProperty', EntityType::class, [
                'label' => 'Свойство',
                'class' => Property::class
            ])
            ->add('value', TextType::class, [
                'label' => 'Значение',
            ])
            ->add('country', ChoiceType::class, [
                'label' => 'Страна',
                'help' => 'При выборе страны - поля "ЗНАЧЕНИЕ" и "МЕРА" игнорируются.',
                'choices' => [
                    'Страна производства' => array_merge(['не выбрано' => null], $countryChoices),
                ],
            ])
            ->add('measure', ChoiceType::class, [
                'label' => 'Мера',
                'help' => 'В поле "ЗНАЧЕНИЕ" укажите величину свойства. А в текущем поле выбирите меру.',
                'choices' => [
                    'Мера измерения' => array_merge(['не выбрано' => null], $measureChoices)
                ]
            ])
            ->add('value', TextType::class, [
                'label' => 'Значение',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProductPropertyValue::class,
        ]);
    }
}
