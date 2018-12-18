<?php

namespace App\Repository;

use App\Entity\PricingRule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PricingRule|null find($id, $lockMode = null, $lockVersion = null)
 * @method PricingRule|null findOneBy(array $criteria, array $orderBy = null)
 * @method PricingRule[]    findAll()
 * @method PricingRule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PricingRuleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PricingRule::class);
    }

    // /**
    //  * @return PricingRule[] Returns an array of PricingRule objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PricingRule
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
