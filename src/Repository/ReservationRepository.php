<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    /**
     * @return Reservation[] retourne un tableau de toutes les réservations confirmées ou non
     */
    public function findAllResa($confirm)
    {
        return $this->createQueryBuilder('r')
            ->where('r.confirm = :confirm')
            ->andWhere('r.date >= :today')
            ->setParameter('today',new \DateTime('today'))
            ->setParameter('confirm', $confirm)
            ->orderBy('r.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Reservation[] retourne un tableau des réservations du jour confirmées au service du midi
     */
    public function findAllDayLunchConfirm()
    {
        $min = date('11:00');
        $max = date('16:00');
        return $this->createQueryBuilder('r')
            ->where('r.confirm = true')
            ->andWhere('r.date = :today')
            ->andwhere('r.time BETWEEN :min AND :max')
            ->setParameter('today',new \DateTime('today'))
            ->setParameter('min', $min) 
            ->setParameter('max', $max)  
            ->orderBy('r.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Reservation[] retourne un tableau des réservations du jour confirmées au service du soir
     */
    public function findAllDayEveningConfirm()
    {
        $min = date('18:00');
        $max = date('23:00');
        return $this->createQueryBuilder('r')
            ->where('r.confirm = true')
            ->andWhere('r.date = :today')
            ->andwhere('r.time BETWEEN :min AND :max')
            ->setParameter('today',new \DateTime('today'))
            ->setParameter('min', $min) 
            ->setParameter('max', $max)  
            ->orderBy('r.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Reservation[] Returns an array of Reservation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reservation
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}