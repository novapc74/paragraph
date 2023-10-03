<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Message\SendEmail;
use App\Form\PopupFeedbackFormType;
use App\Form\FooterFeedbackFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Messenger\MessageBusInterface;

class FeedbackController extends AbstractController
{
	public function __construct(private readonly ManagerRegistry     $managerRegistry,
	                            private readonly MessageBusInterface $bus)
	{
	}

	#[Route('/feedback/popup', name: 'app_feedback_popup', methods: ['GET', 'POST'])]
	public function resolvePopupForm(Request $request): Response
	{
		return $this->resolveForm($request, PopupFeedbackFormType::class);
	}

	#[Route('/feedback/footer', name: 'app_feedback_footer', methods: ['GET', 'POST'])]
	public function resolveFooterForm(Request $request): Response
	{
		return $this->resolveForm($request, FooterFeedbackFormType::class);
	}

	private function resolveForm($request, $formType): Response
	{
		if (!$request->isXmlHttpRequest()) {
			return $this->redirect('/');
		}

		$feedBack = new Feedback();

		$form = $this->createForm($formType, $feedBack);
		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$feedBack = $form->getData();

			$em = $this->managerRegistry->getManager();
			$em->persist($feedBack);
			$em->flush();

			$this->bus->dispatch(new SendEmail($feedBack));

			return $this->json(['success' => true], 201);
		}

		return $this->render("feedback/form.html.twig", [
			'form' => $form->createView()
		]);
	}
}

