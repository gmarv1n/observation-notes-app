<?php
namespace App\Repository;

use App\Entity\ObservingDay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ObservingDayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObservingDay::class);
    }

    public function findById($id): ?ObservingDay {

        return $this->createQueryBuilder('b')
            ->andWhere('b.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findObserversDays($observerId) 
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT od
            FROM App\Entity\ObservingDay od INNER JOIN App\Entity\DaysObservers do
            WITH od.id = do.observing_day_id
            WHERE do.observer_id = :observerId'
        )->setParameter('observerId', $observerId);

        // returns an array 
        return $query->getResult();
    }
}
