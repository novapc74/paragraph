<?php

namespace App\Controller;

use App\Entity\Store;
use App\Entity\Gallery;
use App\Entity\Product;
use App\Enum\PageBlockType;
use App\Repository\ReviewRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Repository\PageBlockRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(ProductRepository $productRepository, PageBlockRepository $pageBlockRepository, ReviewRepository $reviewRepository, CategoryRepository $categoryRepository): Response
    {
        return $this->render('pages/home.html.twig', [
            'isHome' => true,
            'products' => $productRepository->findBy(['parentProduct' => null]),
            'main_blocks' => $pageBlockRepository->findBy(['type' => PageBlockType::product_block_type->name]),
            'interior_blocks' => $pageBlockRepository->findBy(['type' => PageBlockType::interior_block_type->name]),
            'reviews' => $reviewRepository->findBy([], [], 3),
            'reviewAllCount' => count($reviewRepository->findAll()) ?? 0,
            'categories' => $categoryRepository->findBy([], []),
        ]);
    }

    #[Route('/modification/{id}', name: 'app_product_modification')]
    public function showProductModification(Request $request, ?Product $modification): JsonResponse
    {
        if ($request->isXmlHttpRequest() && $modification) {

            $marketplaces = [];
            array_map(function (Store $store) use (&$marketplaces) {
                $marketplaces[$store->getTitle()] = $store->getLink();
            }, $modification->getMarketPlaces()->toArray());

            return $this->json([
                'color' => $modification->getColor()->getTitle(),
                'title' => $modification->getColor()->getModernTitle(),
                'images' => array_map(fn(Gallery $gallery) => '/upload/media/' . $gallery->getImage()->getImageName(), $modification->getGallery()->toArray()),
                'marketplaces' => $marketplaces,
            ]);
        }

        return $this->json(['success' => false, 'message' => sprintf('для модификации "%s" сделайте запрос с заголовком XmlHttpRequest', $modification)], 404);
    }

    #[Route('/review', name: 'app_review', methods: ['GET'])]
    public function getReview(ReviewRepository $reviewRepository, PaginatorInterface $paginator, Request $request): Response
    {
        if (!$request->isXmlHttpRequest()) {
            return $this->json(['error' => 'there is not XmlHttpRequest']);
        }

        $reviews = $reviewRepository->findAll();
        $currentPage = $request->query->getInt('page', 1);

        $pagination = $paginator->paginate(
            $reviews,
            $currentPage,
            3
        );

        return $this->render('components/review/reviews-list.html.twig', [
            'reviews' => $pagination,
            'currentPage' => $currentPage,
        ]);
    }

    #[Route('/catalog', name: 'app_catalog')]
    public function getCatalog(CategoryRepository $categoryRepository): Response
    {
        $catalog = $categoryRepository->findAll();

        return $this->render('pages/catalog.html.twig', compact('catalog'));
    }

    #[Route('/catalog/{slug}', name: 'app_product')]
    public function getProduct(Product $product): Response
    {
        return $this->render('pages/product.html.twig', compact('product'));
    }
}
