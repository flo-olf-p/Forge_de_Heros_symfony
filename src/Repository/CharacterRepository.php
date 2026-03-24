<?php

namespace App\Repository;

use App\Entity\Character;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Character>
 */
class CharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Character::class);
    }

    //    /**
    //     * @return Character[] Returns an array of Character objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Character
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findByClassAndUser(string $class, $user): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.class_character = :class')
            ->andWhere('c.user = :user')

            ->setParameter('class', $class)
            ->setParameter('user', $user)

            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByRaceAndUser(string $race, $user): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.race = :race')
            ->andWhere('c.user = :user')
            ->setParameter('race', $race)
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    public function findByNameAndUser(string $name, $user): array
    {
        return $this->createQueryBuilder('c')
            ->where('c.name LIKE :search')
            ->andWhere('c.user = :user')
            ->setParameter('search', '%' . $name . '%')
            ->setParameter('user', $user)
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByFilters($user, ?string $search, ?string $classId, ?string $raceId): array
    {
        $qb = $this->createQueryBuilder('c')
            ->andWhere('c.user = :user')
            ->setParameter('user', $user);

        if ($search) {
            $qb->andWhere('c.name LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        if ($classId) {
            $qb->andWhere('c.class_character = :class')
                ->setParameter('class', $classId);
        }

        if ($raceId) {
            $qb->andWhere('c.race = :race')
                ->setParameter('race', $raceId);
        }

        return $qb
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
