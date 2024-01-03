<?php

namespace App\Repository;

use App\Entity\Broadcaster;
use App\Query\Cast;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Broadcaster>
 *
 * @method Broadcaster|null find($id, $lockMode = null, $lockVersion = null)
 * @method Broadcaster|null findOneBy(array $criteria, array $orderBy = null)
 * @method Broadcaster[]    findAll()
 * @method Broadcaster[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BroadcasterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Broadcaster::class);
    }

    public function findByBroadcasterRut($value): array
    {
        $config = $this->getEntityManager()->getConfiguration();
        $config->addCustomNumericFunction('CAST', Cast::class);
    
        return $this->createQueryBuilder('s')
            ->where('CAST(s.rut as TEXT) LIKE :val')
            //->setParameter('val', $value)
            ->andWhere("s.DeletedAt IS NULL")
            ->setParameter('val', '%'.strtolower($value).'%')
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(30)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Broadcaster[] Returns an array of Broadcaster objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Broadcaster
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
