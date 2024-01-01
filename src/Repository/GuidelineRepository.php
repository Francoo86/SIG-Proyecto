<?php

namespace App\Repository;

use App\Entity\Guideline;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Guideline>
 *
 * @method Guideline|null find($id, $lockMode = null, $lockVersion = null)
 * @method Guideline|null findOneBy(array $criteria, array $orderBy = null)
 * @method Guideline[]    findAll()
 * @method Guideline[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GuidelineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Guideline::class);
    }

    /**
     * @return Guideline[] Returns an array of Guideline objects
     */
    public function findByShowName($value): array
    {
        return $this->createQueryBuilder('g')
            ->where('g.show_name LIKE :val')
            //->setParameter('val', $value)
            ->setParameter('val', '%'.$value.'%')
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(30)
            ->getQuery()
            ->getResult();
    }

    public function findAllOrderedById(){
        return $this->findBy([], ['id' => 'ASC']);
    }


//    public function findOneBySomeField($value): ?Guideline
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
