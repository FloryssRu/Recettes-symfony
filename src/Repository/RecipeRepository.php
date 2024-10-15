<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recipe>
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipe::class);
    }

    /**
     * Used by random page : return a recipe random chosen by some parameters
     */
    public function findOneByType($type, $isVegetarian, $isVegan): ?Recipe
    {
        $qb = $this->createQueryBuilder('r')
            ->innerJoin('r.types', 't', Join::WITH)
            ->andWhere('t = :type')
            ->setParameter('type', $type)
        ;

        if ($isVegetarian) {
            $qb
                ->andWhere('r.isVegetarian = :isVegetarian')
                ->setParameter('isVegetarian', $isVegetarian)
            ;
        }

        if ($isVegan) {
            $qb
                ->andWhere('r.isVegan = :isVegan')
                ->setParameter('isVegan', $isVegan)
            ;
        }

        return $qb
            ->orderBy('RAND()')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
