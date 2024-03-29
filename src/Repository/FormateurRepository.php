<?php

namespace App\Repository;

use App\Entity\Formateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Formateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formateur[]    findAll()
 * @method Formateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormateurRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Formateur::class);
    }

    public function findBySession($session_id)
    {
        return $this->createQueryBuilder('f')
                    ->innerJoin('f.categories', 'c')
                    ->innerJoin('c.modules', 'm')
                    ->innerJoin('m.composer', 'co')
                    ->innerJoin('co.session', 's')
                    ->where('s.id = :id')
                    ->setParameter('id', $session_id)
                    ->getQuery()
                    ->getResult();
    }

    public function findByName($nom)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
                                'SELECT f
                                FROM App\Entity\Formateur f
                                WHERE f.nom = :nom');
        $query->setParameter('nom', $nom);
        return $query->getSingleResult();
    }

    public function findByCategorie($categorie_id)
    {
        return $this->createQueryBuilder('f')
                    ->innerJoin('f.categories', 'c')
                    ->where('c.id = :id')
                    ->setParameter('id', $categorie_id)
                    ->getQuery()
                    ->getResult();
    }

    // /**
    //  * @return Formateur[] Returns an array of Formateur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Formateur
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
