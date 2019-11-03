<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Service;

use DawBed\ConfirmationBundle\Entity\AbstractToken;
use DawBed\ConfirmationBundle\Entity\TokenInterface;
use DawBed\ConfirmationBundle\Model\CreateModel;
use DawBed\ConfirmationBundle\Model\Criteria\TokenCriteria;

class GenerateService
{
    private $supportTypeService;
    private $createService;

    function __construct(SupportTypeService $supportTypeService, CreateService $createService)
    {
        $this->supportTypeService = $supportTypeService;
        $this->createService = $createService;
    }

    public function prepareModel(TokenCriteria $tokenSetting)
    {
        return new CreateModel((ClassProvider::new(AbstractToken::class))
            ->setType($tokenSetting->getType()), $tokenSetting->getExpiredInterval());
    }

    public function generate(TokenCriteria $tokenSetting): TokenInterface
    {
        $model = $this->prepareModel($tokenSetting);
        $type = $model->getEntity()->getType();

        if (!$this->supportTypeService->check($type)) {
            throw new SupportTypeException(sprintf('"%s" type is not supported. Before use type add him to configuration file.', $type));
        }
        $this->createService->byModel($model);

        return $model->getEntity();
    }
}