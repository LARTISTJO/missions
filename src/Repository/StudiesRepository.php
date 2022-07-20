<?php

namespace App\Repository;

use App\Entity\Studies;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Studies>
 *
 * @method Studies|null find($id, $lockMode = null, $lockVersion = null)
 * @method Studies|null findOneBy(array $criteria, array $orderBy = null)
 * @method Studies[]    findAll()
 * @method Studies[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Studies::class);
    }

    public function add(Studies $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Studies $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findByThemes(): array
   {
      $qb = $this->createQueryBuilder('s');
        $qb->orderBy('s.studytheme', 'ASC');
         $query = $qb->getQuery();

      return $query->execute();

    }

}
