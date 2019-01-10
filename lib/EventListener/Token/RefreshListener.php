<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\EventListener\Token;

use DawBed\ConfirmationBundle\Event\Token\RefreshEvent;
use DawBed\ConfirmationBundle\Service\Token\CreateService;
use DawBed\ConfirmationBundle\Service\Token\GenerateService;
use DawBed\PHPToken\Model\CreateModel;

class RefreshListener
{
    private $createService;

    function __construct(CreateService $createService, GenerateService $generateService)
    {
        $this->createService = $createService;
    }

    function __invoke(RefreshEvent $event): void
    {
        if ($event->getToken()->isConsume()) {
            throw new TokenIsAlreadyConsumedException();
        }
        $this->createService->byModel(new CreateModel($event->getToken(), $event->getSetting()->getExpiredInterval()));
    }
}