<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\EventListener\Token;

use DawBed\ConfirmationBundle\Event\Token\GenerateEvent;
use DawBed\ConfirmationBundle\Service\Token\GenerateService;

class GenerateListener
{
    private $generateService;

    function __construct(GenerateService $generateService)
    {
        $this->generateService = $generateService;
    }

    public function __invoke(GenerateEvent $generateEvent): void
    {
        $model = $this->generateService->prepareModel($generateEvent->getSetting());
        $this->generateService->generate($model);

        $generateEvent->setToken($model->getEntity());
    }
}