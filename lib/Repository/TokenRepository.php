<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Repository;

use DawBed\PHPToken\Token;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Internal\Hydration\IterableResult;

class TokenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, $entityClass = Token::class)
    {
        parent::__construct($registry, $entityClass);
    }

    public function getItterator(): IterableResult
    {
        $qb = $this->createQueryBuilder('t');
        $qb->distinct(true);
        $qb->select('t.type');
        return $qb->getQuery()->iterate();
    }
}