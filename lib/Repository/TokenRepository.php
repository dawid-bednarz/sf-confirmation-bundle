<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Repository;

use DawBed\ConfirmationBundle\Entity\AbstractToken;
use DawBed\PHPClassProvider\ClassProvider;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Internal\Hydration\IterableResult;
use Doctrine\ORM\QueryBuilder;

class TokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, $entityClasss = AbstractToken::class)
    {
        parent::__construct($registry, ClassProvider::get($entityClasss));
    }

    public function getItterator(): IterableResult
    {
        $qb = $this->createQueryBuilder('t');
        $qb->distinct(true);
        $qb->select('t.type');
        return $qb->getQuery()->iterate();
    }

    public function getValidTokenQueryBuilder(string $alias): QueryBuilder
    {
        $qb = $this->createQueryBuilder($alias);
        $qb->where("$alias.consume=:consume")
            ->andWhere("$alias.expired > :expired")
            ->setParameter('consume', 0)
            ->setParameter('expired', new \DateTime());
        return $qb;
    }
}