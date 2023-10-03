<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FeedbackFormType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options): void
	{
		$builder
			->add('name', TextType::class, [
				'label' => 'Имя',
				'constraints' => [
					new NotBlank()
				],
				'attr' => array(
					'placeholder' => 'Имя*'
				)
			])
//            ->add('email', EmailType::class, [
//                'label' => 'Email',
//                'required' => false,
//            ])
			->add('phone', TelType::class, [
				'label' => 'Телефон',
				'constraints' => [
					new NotBlank()
				],
				'attr' => array(
					'placeholder' => 'Телефон*'
				)
			])
			->add('comment', TextareaType::class, [
				'label' => 'Сообщение',
				'required' => false,
				'constraints' => [
					new NotBlank()
				],
				'attr' => array(
					'placeholder' => 'Сообщение'
				)
			])
			->add('agreeTerm', CheckboxType::class, [
				'label' => 'Пользовательское соглашение',
				'label_html' => true,
				'mapped' => false,
			]);
	}

	public function configureOptions(OptionsResolver $resolver): void
	{
		$resolver->setDefaults([
			'inherit_data' => true,
		]);
	}
}
