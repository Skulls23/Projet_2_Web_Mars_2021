<?php

namespace App\Repository;

use App\Entity\Etablissement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Etablissement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Etablissement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Etablissement[]    findAll()
 * @method Etablissement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EtablissementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Etablissement::class);
    }

    public function findByUAI($uai):?Etablissement
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.uai = :val')
            ->setParameter('val', $uai)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findCommunes(int $page): array
    {
        return $this->createQueryBuilder("e")
            ->select("distinct e.code_commune, e.commune")
            ->orderBy("e.commune")
            ->addCriteria(new Criteria(firstResult: ($page-1)*50, maxResults: 50))
            ->getQuery()
            ->getArrayResult();
    }
}
