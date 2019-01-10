<?php
/**
 *  * Created by PhpStorm.
 * User: Dawid Bednarz( dawid@bednarz.pro )
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Service\Token;

use DawBed\PHPToken\Model\CreateModel;
use Doctrine\ORM\EntityManagerInterface;

class CreateService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function byModel(CreateModel $model): EntityManagerInterface
    {
        $unitOfWork = $this->entityManager->getUnitOfWork();
        $token = $model->make();
        $unitOfWork->persist($token);
        $unitOfWork->commit($token);

        return $this->entityManager;
    }
}