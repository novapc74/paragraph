<?php

namespace App\MessageHandler;

use App\Message\SendEmail;
use App\Service\MailerService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SendEmailHandler
{
    public function __construct(private readonly MailerService $mailerService)
    {
    }

    public function __invoke(SendEmail $sendEmail): void
    {
        $this->mailerService->resolveMailer($sendEmail->getFeedback());
    }
}