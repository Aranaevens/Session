<?php

namespace App\Repository;

use App\Entity\Composer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Composer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Composer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Composer[]    findAll()
 * @method Composer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ComposerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Composer::class);
    }

    public function moduleBySession($id){
        return $this->createQueryBuilder('modulcom')
                    ->innerJoin('modulcom.session', 'comsession')
                    ->where('comsession.id = :id')
                    ->setParameter('id', $id)
                    ->getQuery()
                    ->getResult();
    }

    // Renvoie toutes les formations où UN module est enseigné
    public function findByModule($module_id)
    {
        return $this->createQueryBuilder('comp')
                    ->innerJoin('composer.session', 'ses')
                    ->innerJoin('comp.module', 'm')
                    ->where('m.id = :id')
                    ->setParameter('id', $module_id)
                    ->orderBy('ses.intitule', 'ASC')
                    ->getQuery()
                    ->getResult();
    }

    // /**
    //  * @return Composer[] Returns an array of Composer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Composer
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
