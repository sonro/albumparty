<?php

namespace App\Repository;

use App\Entity\UserAlbumRating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserAlbumRating|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserAlbumRating|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserAlbumRating[]    findAll()
 * @method UserAlbumRating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserAlbumRatingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserAlbumRating::class);
    }

    // /**
    //  * @return UserAlbumRating[] Returns an array of UserAlbumRating objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserAlbumRating
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
