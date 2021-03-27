<?php

namespace App\Repository;

use App\Entity\Commentaire;
use App\Entity\Etablissement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentaire[]    findAll()
 * @method Commentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaire::class);
    }

    public function findByUAI($uai, int $page):array
    {
        $etablissement = $this->getEntityManager()->getRepository(Etablissement::class)->findByUAI($uai);
        return $this->createQueryBuilder('e')
            ->andWhere('e.uai = :val')
            ->setParameter('val', $etablissement->getId())
            ->addCriteria(new Criteria(firstResult: ($page-1)*50, maxResults: 50))
            ->getQuery()
            ->getResult();
    }
}
