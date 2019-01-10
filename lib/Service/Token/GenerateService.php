<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Service\Token;

use DawBed\ConfirmationBundle\Service\EntityService;
use DawBed\PHPToken\DTO\TokenSetting;
use DawBed\PHPToken\Model\CreateModel;

class GenerateService
{
    private $supportTypeService;
    private $createService;
    private $entityService;

    function __construct(SupportTypeService $supportTypeService, CreateService $createService, EntityService $entityService)
    {
        $this->supportTypeService = $supportTypeService;
        $this->createService = $createService;
        $this->entityService = $entityService;
    }

    public function prepareModel(TokenSetting $tokenSetting)
    {
        return new CreateModel((new $this->entityService->Token)
            ->setType($tokenSetting->getType()), $tokenSetting->getExpiredInterval());
    }

    public function generate(CreateModel $createModel): void
    {
        $type = $createModel->getEntity()->getType();

        if (!$this->supportTypeService->check($type)) {
            throw new SupportTypeException(sprintf('"%s" type is not supported. Before use type add him to configuration file.', $type));
        }
        $this->createService->byModel($createModel);
    }
}