<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @method Serie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serie[]    findAll()
 * @method Serie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    public function getMenu()
    {
        $qb = $this->createQueryBuilder('serie');

        $qb->addSelect('serie');
        $qb->addOrderBy('serie.isFilm');
        $qb->addOrderBy('serie.debut');

        $qb->leftJoin('serie.films', 'films');

        return $qb->getQuery()->getResult();

    }

    public function getSerieWithSaisons($slug)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->select('s, saisons, personnages, recurringPersonnages');
        $qb->leftJoin('s.saisons','saisons');
        $qb->leftJoin('s.personnages', 'personnages');
        $qb->leftJoin('s.recurringPersonnages', 'recurringPersonnages');
        $qb->andWhere($qb->expr()->eq('s.slug', ':slug'));
        $qb->setParameters(array('slug'=>$slug));

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getSerieWithFilms($slug)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->select('s, films, personnages');
        $qb->leftJoin('s.films','films');
        $qb->leftJoin('s.personnages', 'personnages');
        $qb->andWhere($qb->expr()->eq('s.slug', ':slug'));
        $qb->setParameters(array('slug'=>$slug));

        try {
            return $qb->getQuery()->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }

    // /**
    //  * @return Serie[] Returns an array of Serie objects
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
    public function findOneBySomeField($value): ?Serie
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
