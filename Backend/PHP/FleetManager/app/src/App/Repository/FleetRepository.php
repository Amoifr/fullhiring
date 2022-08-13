<?php

namespace Fulll\App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Fulll\Domain\Entity\Fleet;

/**
 * @method Fleet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fleet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fleet[]    findAll()
 * @method Fleet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FleetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fleet::class);
    }

    public function save(Fleet $fleet): void
    {
        $this->_em->persist($fleet);
        $this->_em->flush();
    }
}
