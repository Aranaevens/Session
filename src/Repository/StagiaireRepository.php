<?php

namespace App\Repository;

use App\Entity\Stagiaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Stagiaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stagiaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stagiaire[]    findAll()
 * @method Stagiaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StagiaireRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Stagiaire::class);
    }

    public function findByName($prenom, $nom)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
                                'SELECT s
                                FROM App\Entity\Stagiaire s
                                WHERE s.nom = :nom
                                AND s.prenom = :prenom');
        $query->setParameter('nom', $nom);
        $query->setParameter('prenom', $prenom);
        return $query->getOneOrNullResult();
    }

    public function StagiairesByFormation($id){
        // $entityManager = $this->getEntityManager();
        // $query = $entityManager->createQuery(
        //                         'SELECT s
        //                         FROM App\Entity\Stagiaire s
        //                         INNER JOIN App\Entity\Session ss
        //                         WITH s.sessions = ss.stagiaires
        //                         WHERE ss.id = :id');
        // $query->setParameter('id',$id);
        // return $query->execute();

        return $this->createQueryBuilder('sta')
                    ->innerJoin('sta.sessions', 'ses')
                    ->where('ses.id = :id')
                    ->setParameter('id', $id)
                    ->getQuery()
                    ->getResult();
    }

    // /**
    //  * @return Stagiaire[] Returns an array of Stagiaire objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Stagiaire
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
