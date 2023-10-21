<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Entity\Country;
use App\Entity\Feedback;
use App\Entity\Review;
use App\Entity\SocialNetwork;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function admin(): Response
    {
        return $this->render('@EasyAdmin/page/content.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<span style="color: red">&#167;</span> PARAGRAPH');
    }

    public function configureCrud(): Crud
    {
        return parent::configureCrud()
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Пользователи', 'fa-solid fa-user', User::class);

        yield MenuItem::section('обратная связь');
        yield MenuItem::linkToCrud('Сообщения', 'fa-solid fa-comment', Feedback::class);
        yield MenuItem::linkToCrud('Отзывы', 'fa-solid fa-comments', Review::class);

        yield MenuItem::section('контакты');
        yield MenuItem::linkToCrud('Контакты', 'fa-regular fa-address-card', Contact::class);
        yield MenuItem::linkToCrud('Соц.сети', 'fa-brands fa-twitter', SocialNetwork::class);

        yield MenuItem::section('товары');
        yield MenuItem::linkToCrud('Страны', 'fa-solid fa-globe', Country::class);
    }
}
