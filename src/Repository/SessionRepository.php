<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Session::class);
    }

    public function getAll(){
        $entityManager = $this->getEntityManager();
        $query = $entityManager-createQuery(
                        'SELECT s
                            FROM App\Entity\Session s 
                            ORDER BY s.dateDebut ASC'
        );
        return $query -> execute();
    }

    // Renvoie la session nommée $intitule, sert pour les fixtures principalement
    public function findByIntitule($intitule)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
                                'SELECT s
                                FROM App\Entity\Session s
                                WHERE s.intitule = :intitule');
        $query->setParameter('intitule', $intitule);
        return $query->getOneOrNullResult();
    }

    // Renvoie toutes les formations suivies par UN stagiaire
    public function findByStagiaire($stagiaire_id)
    {
        return $this->createQueryBuilder('ses')
                    ->innerJoin('ses.stagiaires', 'sta')
                    ->where('sta.id = :id')
                    ->setParameter('id', $stagiaire_id)
                    ->orderBy('ses.dateDebut', 'DESC')
                    ->getQuery()
                    ->getResult();
    }

    // Renvoie toutes les formations où UN formateur intervient
    public function findByFormateur($formateur_id)
    {
        return $this->createQueryBuilder('ses')
                    ->innerJoin('ses.composer', 'comp')
                    ->innerJoin('comp.module', 'm')
                    ->innerJoin('m.categorie', 'cat')
                    ->innerJoin('cat.formateurs', 'f')
                    ->where('f.id = :id')
                    ->setParameter('id', $formateur_id)
                    ->orderBy('ses.dateDebut', 'DESC')
                    ->getQuery()
                    ->getResult();
    }

    // Renvoie toutes les formations où UN module est enseigné
    public function findByModule($module_id)
    {
        return $this->createQueryBuilder('ses')
                    ->innerJoin('ses.composer', 'comp')
                    ->innerJoin('comp.module', 'm')
                    ->where('m.id = :id')
                    ->setParameter('id', $module_id)
                    ->orderBy('ses.intitule', 'ASC')
                    ->getQuery()
                    ->getResult();
    }


    // /**
    //  * @return Session[] Returns an array of Session objects
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
    public function findOneBySomeField($value): ?Session
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
