<?php

namespace App\Controller;

use App\Entity\Feedback;
use App\Message\SendEmail;
use App\Form\FeedbackFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Messenger\MessageBusInterface;

class FeedbackController extends AbstractController
{
    #[Route('/feedback', name: 'app_feedback', methods: ['GET', 'POST'])]
    public function index(Request             $request,
                          ManagerRegistry     $managerRegistry,
                          MessageBusInterface $bus): Response
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->redirect('/');
        }

        $identifier = $request->query->get('identifier', 'single');

        $feedBack = new Feedback();

        $form = $this->createFormBuilder($feedBack)
            ->create($identifier, FeedbackFormType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $feedBack = $form->getData();

            $em = $managerRegistry->getManager();
            $em->persist($feedBack);
            $em->flush();

            $bus->dispatch(new SendEmail($feedBack));

            return $this->json(['success' => true], 201);
        }

        return $this->render("feedback/form.html.twig", [
            'form' => $form->createView()
        ]);
    }
}

