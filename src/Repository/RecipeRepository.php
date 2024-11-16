<?php

namespace App\Repository;

use App\Entity\Recipe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * @extends ServiceEntityRepository<Recipe>
 */
class RecipeRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        protected ParameterBagInterface $parameterBag
    ) {
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

    /**
     * Return a QueryBuilder filled with params
     * to make a search or get total of pages
     */
    private function getQBForSearch(Recipe $params): QueryBuilder {
        $qb = $this->createQueryBuilder('r');

        if ($params->getIsVegetarian()) {
            $qb
                ->andWhere('r.isVegetarian = :isVegetarian')
                ->setParameter('isVegetarian', true)
            ;
        }

        if ($params->getIsVegan()) {
            $qb
                ->andWhere('r.isVegan = :isVegan')
                ->setParameter('isVegan', true)
            ;
        }

        if (count($params->getTypes()->toArray()) > 0) {
            $qb->innerJoin('r.types', 't', Join::WITH);
            $where = '';
            foreach ($params->getTypes() as $key => $type) {
                $where .= 't = :type' . $key;
                if (count($params->getTypes()) - 1 != $key) $where .= ' OR ';
            }
            $qb->andWhere($where);
            foreach ($params->getTypes() as $key => $type) {
                $qb->setParameter('type'.$key, $type);
            }
        }
        return  $qb;
    }

    /**
     * Used by random page : return a recipe random chosen by some parameters
     */
    public function findAllByType(int $page, Recipe $params): array
    {
        $qb = $this->getQBForSearch($params);

        return $qb
            ->setMaxResults($this->parameterBag->get('ITEM_BY_PAGE'))
            ->setFirstResult($this->parameterBag->get('ITEM_BY_PAGE') * $page)
            ->addOrderBy('r.createdAt')
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * Return the total of pages for these search params
     */
    public function findTotalOfPages(Recipe $params): int
    {
        $qb = $this->getQBForSearch($params);
        $qb->select('count(r.id) as count');
        $results = $qb->getQuery()->getOneOrNullResult();
        return ceil($results['count'] / $this->parameterBag->get('ITEM_BY_PAGE'));
    }
}
