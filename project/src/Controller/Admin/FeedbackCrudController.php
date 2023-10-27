<?php

namespace App\Controller\Admin;

use App\Entity\Feedback;
use App\Entity\Subscriber;
use App\Repository\FeedbackRepository;
use App\Repository\SubscriberRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class FeedbackCrudController extends AbstractCrudController
{
	public static function getEntityFqcn(): string
	{
		return Feedback::class;
	}

	public function configureCrud(Crud $crud): Crud
	{
		return $crud
			->setEntityLabelInSingular('сообщение')
			->setEntityLabelInPlural('Сообщения')
			->setPageTitle('new', 'Создать новое сообщение')
			->setPageTitle('edit', fn(FeedBack $feedBack) => sprintf('Редактировать сообщение от %s', $feedBack->getName()));
	}

	public function configureActions(Actions $actions): Actions
	{
		$getSubscriberTypes = Action::new('get subscriber type', 'Виды подписок')
			->setTemplatePath('admin/subscription_type.html.twig')
			->setHtmlAttributes([
				'data-bs-toggle' => 'modal',
				'data-bs-target' => '#customModal',
			])
			->createAsGlobalAction()
			->linkToCrudAction('getSubscriberTypes')
			->setCssClass('btn btn-warning');

		return parent::configureActions($actions)
			->add('index', $getSubscriberTypes);
	}

	public function configureFields(string $pageName): iterable
	{
		return [
			TextField::new('name', 'Имя')
				->setTextAlign('center')
				->setColumns('col-sm-6 col-lg-5 col-xxl-3')
			,
			FormField::addRow(),
			TelephoneField::new('phone', 'Телефон')
				->setTextAlign('center')
				->setColumns('col-sm-6 col-lg-5 col-xxl-3')
			,
			FormField::addRow(),
			EmailField::new('email', 'Почта')
				->setTextAlign('center')
				->setColumns('col-sm-6 col-lg-5 col-xxl-3')
			,
			FormField::addRow(),
			TextareaField::new('comment', 'Комментарий')
				->setTextAlign('center')
				->setColumns('col-sm-6 col-lg-5 col-xxl-3')
			,
		];
	}

	#[Route('/api/feedback/emails')]
	public function getFeedbackEmails(FeedbackRepository $feedbackRepository): Response
	{
		$emails = [];

		array_map(function (Feedback $feedback) use (&$emails) {
			$email = $feedback->getEmail();
			if (!in_array($email, $emails)) {
				$emails[] = $email;
			}
		}, $feedbackRepository->findAll());

		if (count($emails) === 0) {
			$emails[] = 'сообщений пока нет';
		}

		return $this->render('admin/subscription-type.html.twig', compact('emails'));
	}
}
