<?php
namespace App\Repository;

use App\Entity\ObservingObject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ObservingObjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObservingObject::class);
    }

    public function findById($id): ?ObservingObject {

        return $this->createQueryBuilder('b')
            ->andWhere('b.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function findObserversObjects($observerId) 
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT ob
            FROM App\Entity\ObservingObject ob 
            INNER JOIN App\Entity\DaysObjects do
            WITH ob.id = do.observing_object_id
            INNER JOIN App\Entity\DaysObservers dobs
            WITH do.observing_day_id = dobs.observing_day_id
            WHERE dobs.observer_id = :observerId'
        )->setParameter('observerId', $observerId);

        // returns an array 
        return $query->getResult();
    }

    public function findObjectsByDay($observerId, $dayId) 
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT ob
            FROM App\Entity\ObservingObject ob 
            INNER JOIN App\Entity\DaysObjects do
            WITH ob.id = do.observing_object_id
            INNER JOIN App\Entity\DaysObservers dobs
            WITH do.observing_day_id = dobs.observing_day_id
            WHERE do.observing_day_id = :dayId AND dobs.observer_id = :observerId'
        )->setParameter('observerId', $observerId)
        ->setParameter('dayId', $dayId);

        // returns an array 
        return $query->getResult();
    }

    public function deleteObject($objectId) 
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'DELETE App\Entity\ObservingObject od 
            WHERE od.id = :objectId'
        )->setParameter('objectId', $objectId);

        // returns an array 
        return $query->getResult();
    }
}
