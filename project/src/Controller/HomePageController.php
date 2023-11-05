<?php

namespace App\Controller;

use App\Entity\Product;
use App\Enum\PageBlockType;
use App\Repository\ProductRepository;
use App\Repository\PageBlockRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'app_home_page')]
    public function index(ProductRepository $productRepository, PageBlockRepository $pageBlockRepository): Response
    {
        return $this->render('pages/home.html.twig', [
            'isHome' => true,
            'products' => $productRepository->findBy(['parentProduct' => null]),
            'main_blocks' => $pageBlockRepository->findBy(['type' => PageBlockType::product_block_type->name]),
            'interior_blocks' => $pageBlockRepository->findBy(['type' => PageBlockType::interior_block_type->name]),
        ]);
    }

    #[Route('/modification/{id}', name: 'app_product_modification')]
    public function showProductModification(Request $request, ?Product $modification): JsonResponse
    {
        if ($request->isXmlHttpRequest() && $modification) {

            return $this->json($modification, 200, [], [
                AbstractNormalizer::GROUPS => ['modification:item']
            ]);
        }

        return $this->json(['success' => false, 'message' => sprintf('для модификации "%s" сделайте запрос с заголовком XmlHttpRequest', $modification)], 404);
    }
}
