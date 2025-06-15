<?php

namespace App\Repository;

use App\Entity\Classement;
use App\Entity\Competition;
use App\Entity\Sport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Classement>
 */
class ClassementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classement::class);
    }

    /**
     * Trouve les classements par compétition, triés par points décroissants
     */
    public function findByCompetitionOrderedByPoints(Competition $competition): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.competition = :competition')
            ->setParameter('competition', $competition)
            ->orderBy('c.points', 'DESC')
            ->addOrderBy('c.victoires', 'DESC')
            ->addOrderBy('c.defaites', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Trouve les classements par sport
     */
    public function findBySport(Sport $sport): array
    {
        return $this->createQueryBuilder('c')
            ->join('c.competition', 'comp')
            ->andWhere('comp.sport = :sport')
            ->setParameter('sport', $sport)
            ->orderBy('c.points', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Statistiques globales pour le dashboard
     */
    public function getStatistiquesGlobales(): array
    {
        $qb = $this->createQueryBuilder('c');
        
        return [
            'totalClassements' => $qb->select('COUNT(c.id)')
                ->getQuery()
                ->getSingleScalarResult(),
            'totalPoints' => $qb->select('SUM(c.points)')
                ->getQuery()
                ->getSingleScalarResult(),
            'totalVictoires' => $qb->select('SUM(c.victoires)')
                ->getQuery()
                ->getSingleScalarResult(),
            'totalDefaites' => $qb->select('SUM(c.defaites)')
                ->getQuery()
                ->getSingleScalarResult()
        ];
    }

    /**
     * Top 10 des meilleurs classements
     */
    public function getTop10(): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.points', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
