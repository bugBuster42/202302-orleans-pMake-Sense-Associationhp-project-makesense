<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Category;
use App\Entity\Decision;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Decision>
 *
 * @method Decision|null find($id, $lockMode = null, $lockVersion = null)
 * @method Decision|null findOneBy(array $criteria, array $orderBy = null)
 * @method Decision[]    findAll()
 * @method Decision[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class DecisionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Decision::class);
    }

    public function save(Decision $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Decision $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findDecision(?string $title, ?string $status, ?Category $category, ?User $user = null): array
    {
        $queryBuilder = $this->createQueryBuilder('d');

        if ($title) {
            $queryBuilder->where('d.title LIKE :title');
            $queryBuilder->setParameter('title', '%' . $title . '%');
        }

        if ($status) {
            $queryBuilder->andWhere('d.currentPlace = :status');
            $queryBuilder->setParameter('status', $status);
        }
        if ($category) {
            $queryBuilder->andWhere('d.category = :category');
            $queryBuilder->setParameter('category', $category);
        }
        if ($user) {
            $queryBuilder->andWhere('d.user = :user');
            $queryBuilder->setParameter('user', $user);
        }
        $queryBuilder->orderBy('d.title', 'ASC');

        return $queryBuilder->getQuery()->getResult();
    }
}
