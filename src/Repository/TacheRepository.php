<?php

namespace App\Repository;

use App\Entity\Tache;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Tache>
 */
class TacheRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tache::class);
    }

    //    /**
    //     * @return Tache[] Returns an array of Tache objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('t.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Tache
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    // src/Repository/TacheRepository.php

public function getTauxTachesExecuteesSemaine(): array
{
    $debutSemaine = new \DateTimeImmutable('monday this week');
    $finSemaine = new \DateTimeImmutable('sunday this week');

    $qb = $this->createQueryBuilder('t')
        ->select(
            'COUNT(t.id) as total',
            'SUM(CASE WHEN t.statut = :executee THEN 1 ELSE 0 END) as executees'
        )
        ->where('t.date_echeance BETWEEN :debut AND :fin')
        ->setParameter('executee', 'Executée')
        ->setParameter('debut', $debutSemaine)
        ->setParameter('fin', $finSemaine);

    $result = $qb->getQuery()->getSingleResult();

    $total = (int) $result['total'];
    $executees = (int) $result['executees'];
    $taux = $total > 0 ? round(($executees / $total) * 100, 2) : 0;

    return [
        'total' => $total,
        'executees' => $executees,
        'taux' => $taux,
    ];
}

}
