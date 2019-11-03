<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Service;

use DawBed\PHPToken\Model\AcceptModel;
use Doctrine\ORM\EntityManagerInterface;

class AcceptService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function byModel(AcceptModel $model): EntityManagerInterface
    {
        $this->entityManager
            ->persist($model->make());

        return $this->entityManager;
    }
}