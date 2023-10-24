<?php

namespace App\Controller;

use App\Entity\PropertyGroup;
use App\Entity\ProductPropertyValue;
use App\Repository\ProductRepository;
use App\Repository\PropertyGroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
	#[Route('/', name: 'app_home_page')]
	public function index(PropertyGroupRepository $groupRepository, ProductRepository $productRepository): Response
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
		]);
	}
}
