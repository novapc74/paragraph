<?php

namespace App\Controller\Admin;

use App\Entity\PageBlock;
use App\Entity\User;
use App\Entity\Color;
use App\Entity\Review;
use App\Entity\Product;
use App\Entity\Contact;
use App\Entity\Country;
use App\Entity\Measure;
use App\Entity\Property;
use App\Entity\Category;
use App\Entity\Feedback;
use App\Entity\PropertyGroup;
use App\Entity\SocialNetwork;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function admin(): Response
    {
        return $this->render('@EasyAdmin/page/content.html.twig');
    }

    public function configureAssets(): Assets
    {
        return Assets::new()
            ->addWebpackEncoreEntry('admin')//			->addJsFile('/build/ckeditor/ckeditor.js?v=1.1')
            ;
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

        yield MenuItem::section('общая информация');
        yield MenuItem::linkToCrud('Страны', 'fa-solid fa-globe', Country::class);
        yield MenuItem::linkToCrud('Цвета', 'fa-solid fa-palette', Color::class);
        yield MenuItem::linkToCrud('Меры измерения', 'fa-solid fa-scale-balanced', Measure::class);

        yield MenuItem::section('каталог');
        yield MenuItem::linkToCrud('Категории', 'fa-solid fa-list', Category::class);
        yield MenuItem::linkToCrud('Товары', 'fa-brands fa-product-hunt', Product::class);
        yield MenuItem::linkToCrud('Группы свойств', 'fa-solid fa-layer-group', PropertyGroup::class);
        yield MenuItem::linkToCrud('Названия свойства', 'fa-solid fa-barcode', Property::class);

        yield MenuItem::section('Блоки на главной');
        yield MenuItem::linkToCrud('Тип блока', 'fa-solid fa-cube', PageBlock::class);
    }
}
