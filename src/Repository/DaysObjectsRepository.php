<?php
namespace App\Repository;

use App\Entity\DaysObjects;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DaysObjectsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DaysObjects::class);
    }

    public function findRelationByObjectId($objectId): ?DaysObjects {

        return $this->createQueryBuilder('b')
            ->andWhere('b.observing_object_id = :id')
            ->setParameter('id', $objectId)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function deleteRelationByObjectId($objectId) 
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'DELETE App\Entity\DaysObjects od 
            WHERE od.id = :objectId'
        )->setParameter('objectId', $objectId);

        // returns an array 
        return $query->getResult();
    }
}