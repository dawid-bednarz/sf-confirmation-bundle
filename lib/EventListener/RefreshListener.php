<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\EventListener;

use DawBed\ConfirmationBundle\Event\RefreshEvent;
use DawBed\ConfirmationBundle\Exception\TokenIsAlreadyConsumedException;
use DawBed\ConfirmationBundle\Model\WriteModel;
use DawBed\ConfirmationBundle\Service\WriteService;

class RefreshListener
{
    private $writeService;

    function __construct(WriteService $writeService)
    {
        $this->writeService = $writeService;
    }

    function __invoke(RefreshEvent $event): void
    {
        if ($event->getToken()->isConsume()) {
            throw new TokenIsAlreadyConsumedException();
        }
        $this->writeService->create(WriteModel::baseInstance($event->getToken(), $event->getSetting()->getExpiredInterval()));
    }
}