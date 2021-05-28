<?php
namespace App\Repository;

use App\Entity\DaysObservers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DaysObserversRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DaysObservers::class);
    }

    public function findByDayId($id): ?DaysObservers {

        return $this->createQueryBuilder('b')
            ->andWhere('b.observing_day_id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    public function findAllDays($observerId): ?array
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.observer_id = :observer_id')
            ->setParameter('observer_id', $observerId)
            ->orderBy('b.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}