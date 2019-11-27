<?php

/**
 * @author Dawid Bednarz( dawid@bednarz.pro )
 * @license Read README.md file for more information and licence uses
 */

namespace DawBed\ConfirmationBundle\Service;

use DawBed\ConfirmationBundle\Entity\AbstractToken;
use DawBed\ConfirmationBundle\Entity\TokenInterface;
use DawBed\ConfirmationBundle\Model\WriteModel;
use DawBed\ConfirmationBundle\Model\Criteria\TokenCriteria;
use DawBed\PHPClassProvider\ClassProvider;
use Doctrine\ORM\EntityManagerInterface;
use Firebase\JWT\JWT;

class WriteService
{
    private $supportTypeService;
    private $entityManager;

    function __construct(SupportTypeService $supportTypeService, EntityManagerInterface $entityManager)
    {
        $this->supportTypeService = $supportTypeService;
        $this->entityManager = $entityManager;
    }

    public function prepareModel(TokenCriteria $tokenSetting): WriteModel
    {
        return WriteModel::baseInstance((ClassProvider::new(AbstractToken::class))
            ->setData($tokenSetting->getData())
            ->setType($tokenSetting->getType()), $tokenSetting->getExpiredInterval());
    }

    public function make(WriteModel $model): EntityManagerInterface
    {
        $token = $model->make();
        $unitOfWork = $this->entityManager->getUnitOfWork();
        $unitOfWork->persist($token);
        $unitOfWork->commit($token);

        return $this->entityManager;
    }

    public function generate(TokenCriteria $tokenSetting): TokenInterface
    {
        $model = $this->prepareModel($tokenSetting);

        $this->supportTypeService->check($model->getEntity()->getType());

        $this->make($model);

        return $model->getEntity();
    }
}