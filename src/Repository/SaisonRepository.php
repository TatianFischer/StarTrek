<?php

namespace App\Repository;

use App\Entity\Saison;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * @method Saison|null find($id, $lockMode = null, $lockVersion = null)
 * @method Saison|null findOneBy(array $criteria, array $orderBy = null)
 * @method Saison[]    findAll()
 * @method Saison[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SaisonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Saison::class);
    }

    /**
     * @param $serieSlug
     * @param $saisonNumber
     * @return mixed|null
     * @throws NonUniqueResultException
     */
    public function getSaison($serieSlug, $saisonNumber)
    {
        $qb = $this->createQueryBuilder('saison');

        $qb->select('saison, serie, episodes');

        $qb->innerJoin('saison.serie', 'serie', 'WITH', 'serie.slug = :serieSlug');
        $qb->leftJoin('saison.episodes', 'episodes');

        $qb->where('saison.number = :saisonNumber');

        $qb->setParameters(array(
            'saisonNumber' => $saisonNumber,
            'serieSlug' => $serieSlug
        ));

        $qb->addOrderBy('episodes.number');

        try{
            return $qb->getQuery()->getSingleResult();
        }catch(NoResultException $e){
            return null;
        }
    }

    // /**
    //  * @return Saison[] Returns an array of Saison objects
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
    public function findOneBySomeField($value): ?Saison
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
