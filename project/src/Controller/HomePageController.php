<?php

namespace App\Controller;

use App\Entity\PageBlock;
use App\Entity\PropertyGroup;
use App\Entity\ProductModification;
use App\Entity\ProductPropertyValue;
use App\Repository\PageBlockRepository;
use App\Repository\ProductRepository;
use App\Repository\PropertyGroupRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
	#[Route('/', name: 'app_home_page')]
	public function index(PropertyGroupRepository $groupRepository,
                          ProductRepository $productRepository,
                          PageBlockRepository $pageBlockRepository): Response
	{
		$propertyGroups = [];
		if ($product = $productRepository->findOneBy([])) {

			array_map(
				function (PropertyGroup $group) use (&$propertyGroups, $product) {
					$propertyGroups[$group->getTitle()] = array_filter(
						$product->getProductProperties()->toArray(),
						fn(ProductPropertyValue $productPropertyValue) => $productPropertyValue->getProduct() === $product && $productPropertyValue->getProductProperty()->getPropertyGroup() === $group);
				},
				$groupRepository->findByProduct($product)
			);
		}


		return $this->render('pages/home.html.twig', [
			'isHome' => true,
			'propertyGroups' => $propertyGroups,
			'product' => $product,
            'main_blocks' => $pageBlockRepository->findBy(['type' => PageBlock::getAvailableType()['Продукт']]),
            'interior_blocks' => $pageBlockRepository->findBy(['type' => PageBlock::getAvailableType()['Интерьер']]),
		]);
	}

	#[Route('/modification/{id}', name: 'app_product_modification')]
	public function showProductModification(Request $request, ?ProductModification $modification): JsonResponse
	{
		if ($request->isXmlHttpRequest() && $modification) {

			return $this->json($modification, 200, [], [
				AbstractNormalizer::GROUPS => ['modification:item']
			]);
		}

		return $this->json(['success' => false, 'message' => sprintf('для модификации "%s" сделайте запрос с заголовком XmlHttpRequest', $modification)], 404);
	}
}
