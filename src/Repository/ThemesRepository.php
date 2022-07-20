<?php

namespace App\Repository;

use App\Entity\Themes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Themes>
 *
 * @method Themes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Themes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Themes[]    findAll()
 * @method Themes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ThemesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Themes::class);
    }

    public function add(Themes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Themes $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
