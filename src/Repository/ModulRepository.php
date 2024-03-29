<?php

namespace App\Repository;

use App\Entity\Modul;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Modul|null find($id, $lockMode = null, $lockVersion = null)
 * @method Modul|null findOneBy(array $criteria, array $orderBy = null)
 * @method Modul[]    findAll()
 * @method Modul[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModulRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Modul::class);
    }

    public function findByIntitule($intitule)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
                                'SELECT m
                                FROM App\Entity\Modul m
                                WHERE m.intitule = :intitule');
        $query->setParameter('intitule', $intitule);
        return $query->getOneOrNullResult();
    }

    public function findAllOrder()
    {
        return $this->createQueryBuilder('m')
                    ->innerJoin('m.categorie', 'c')
                    ->orderBy('c.intitule')
                    ->getQuery()
                    ->getResult();
    }

   
    // /**
    //  * @return Modul[] Returns an array of Modul objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Modul
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
