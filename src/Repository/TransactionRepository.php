<?php

namespace App\Repository;

use App\Entity\Transaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Transaction>
 */
class TransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transaction::class);
    }

    //    /**
    //     * @return Transaction[] Returns an array of Transaction objects
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

    //    public function findOneBySomeField($value): ?Transaction
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    // src/Repository/TransactionRepository.php
public function getTotauxTrimestrielsParType(string $type, int $annee): array
{
    $conn = $this->getEntityManager()->getConnection();

    $sql = "
        SELECT 
            CEIL(MONTH(date) / 3) AS trimestre,
            SUM(montant) AS total
        FROM transaction
        WHERE type = :type AND YEAR(date) = :annee
        GROUP BY trimestre
        ORDER BY trimestre
    ";

    $stmt = $conn->prepare($sql);
    $result = $stmt->executeQuery([
        'type' => $type,
        'annee' => $annee,
    ])->fetchAllAssociative();

    return $result;
}


public function getRevenusTrimestriels(): array
{
    $conn = $this->getEntityManager()->getConnection();

    $sql = "
        SELECT 
            CEIL(MONTH(t.date) / 3) AS trimestre,
            YEAR(t.date) AS annee,
            SUM(t.montant) AS total
        FROM transaction t
        WHERE t.type = 'Actif'
        GROUP BY annee, trimestre
        ORDER BY annee, trimestre
    ";

    $stmt = $conn->prepare($sql);
    $result = $stmt->executeQuery();

    return $result->fetchAllAssociative();
}


public function getTotalParTypeEtAnnee(string $type, int $annee): int
{
    $conn = $this->getEntityManager()->getConnection();

    $sql = '
        SELECT SUM(montant) as total
        FROM transaction
        WHERE type = :type AND YEAR(date) = :annee
    ';

    $result = $conn->prepare($sql)->executeQuery([
        'type' => $type,
        'annee' => $annee,
    ])->fetchAssociative();

    return (int) ($result['total'] ?? 0); // retourne 0 si NULL
}

public function getTotauxMensuelsParType(string $type, int $annee): array
{
    $conn = $this->getEntityManager()->getConnection();

    $sql = '
        SELECT MONTH(date) as mois, SUM(montant) as total
        FROM transaction
        WHERE type = :type AND YEAR(date) = :annee
        GROUP BY mois
        ORDER BY mois
    ';
    $result = $conn->prepare($sql)->executeQuery([
        'type' => $type,
        'annee' => $annee,
    ])->fetchAllAssociative();

    return $result;
}

public function getMontantsMensuelsParType(string $type): array
{
    $conn = $this->getEntityManager()->getConnection();

    $sql = "
        SELECT YEAR(date) AS annee, MONTH(date) AS mois, SUM(montant) AS total
        FROM transaction
        WHERE type = :type
        GROUP BY annee, mois
        ORDER BY annee, mois
    ";

    // Prépare et exécute la requête avec les paramètres
    $result = $conn->prepare($sql)
        ->executeQuery(['type' => $type])
        ->fetchAllAssociative();

    return $result;
}

}
