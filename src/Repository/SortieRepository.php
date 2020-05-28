<?php

namespace App\Repository;

use App\Entity\Sortie;
use App\Entity\SortiesSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    /**
     * @return Sortie[] Returns an array of Sortie objects
     */

    public function findAllSorties(SortiesSearch $search)

    {
        $qb = $this->createQueryBuilder('s');

        $qb->leftJoin('s.participants', 'p');
        $qb->addSelect('p');
        $qb->leftjoin('s.organisateur', 'o');
        $qb->addSelect('o');
        $qb->addOrderBy('s.dateHeureDebut');


        $qb->andWhere("DATE_ADD(DATE_ADD(s.dateHeureDebut, s.duree, 'minute'), 1, 'month') > :now")
            ->setParameter('now', new \DateTime("now"));

        if($search->getCampus() || $search->getCampus() != null){
            $qb->andWhere('s.campusOrganisateur = :campus')
                ->setParameter('campus', $search->getCampus());
        }

        if($search->getKeyword() || $search->getKeyword() != null){
            $qb->andWhere('s.nom LIKE :keyword')
                ->setParameter('keyword', "%" . $search->getKeyword() . "%");
        }

        if($search->getDateDebut() || $search->getDateDebut() != null){
            $qb->andWhere('s.dateHeureDebut > :dateDebut')
                ->setParameter('dateDebut', $search->getDateDebut());
        }

        if($search->getDateFin() || $search->getDateFin() != null){
            $qb->andWhere('s.dateHeureDebut < :dateCloture')
                ->setParameter('dateCloture', $search->getDateFin());
        }

        $qb =$qb->getQuery();
        return $qb->execute();

    }


    /*
    public function findOneBySomeField($value): ?Sortie
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
