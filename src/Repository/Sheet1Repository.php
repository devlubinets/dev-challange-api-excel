<?php

namespace App\Repository;

use App\Entity\Sheet1;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sheet1>
 *
 * @method Sheet1|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sheet1|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sheet1[]    findAll()
 * @method Sheet1[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Sheet1Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sheet1::class);
    }

//    /**
//     * @return Sheet1[] Returns an array of Sheet1 objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sheet1
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
