<?php

namespace App\Repository;

use App\Entity\ProductModification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProductModification>
 *
 * @method ProductModification|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductModification|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductModification[]    findAll()
 * @method ProductModification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductModificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductModification::class);
    }

//    /**
//     * @return ProductModification[] Returns an array of ProductModification objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProductModification
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
