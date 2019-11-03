<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\EventListener;

use DawBed\ConfirmationBundle\Event\GenerateEvent;
use DawBed\ConfirmationBundle\Service\GenerateService;

class GenerateListener
{
    private $generateService;

    function __construct(GenerateService $generateService)
    {
        $this->generateService = $generateService;
    }

    public function __invoke(GenerateEvent $generateEvent): void
    {
        $generateEvent->setToken($this->generateService->generate($generateEvent->getSetting()));
    }
}