<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\EventListener;

use DawBed\ConfirmationBundle\Event\RefreshEvent;
use DawBed\ConfirmationBundle\Service\CreateService;

class RefreshListener
{
    private $createService;

    function __construct(CreateService $createService)
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