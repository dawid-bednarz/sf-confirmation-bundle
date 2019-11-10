<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\EventListener;

use DawBed\ConfirmationBundle\Event\GenerateEvent;
use DawBed\ConfirmationBundle\Service\WriteService;

class GenerateListener
{
    private $service;

    function __construct(WriteService $service)
    {
        $this->service = $service;
    }

    public function __invoke(GenerateEvent $generateEvent): void
    {
        $generateEvent->setToken($this->service->generate($generateEvent->getSetting()));
    }
}