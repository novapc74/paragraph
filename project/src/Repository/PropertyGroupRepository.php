<?php

namespace App\Repository;

use App\Entity\Product;
use App\Entity\PropertyGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PropertyGroup>
 *
 * @method PropertyGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method PropertyGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method PropertyGroup[]    findAll()
 * @method PropertyGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PropertyGroup::class);
    }

    /**
     * @return PropertyGroup[] Returns an array of PropertyGroup objects
     */
    public function findByProduct(Product $product): array
    {
        return $this->createQueryBuilder('p')
	        ->leftJoin('p.properties', 'productProperty')
	        ->leftJoin('productProperty.productPropertyValues', 'productPropertyValue')
            ->andWhere('productPropertyValue.product = :val')
            ->setParameter('val', $product)
            ->orderBy('p.position', 'ASC')
            ->setMaxResults(20)
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?PropertyGroup
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
