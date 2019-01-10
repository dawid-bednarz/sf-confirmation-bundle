<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Event;

use DawBed\ComponentBundle\Event\AbstractEvents;

class Events extends AbstractEvents
{
    const GENERATE_TOKEN = 'token.generate';
    const REFRESH_TOKEN = 'token.refresh';
    const ACCEPT_TOKEN = 'token.accept_';
    const ERROR_ACCEPT_TOKEN = 'token.accept.error_';

    const ALL = [
        self::GENERATE_TOKEN => self::OPTIONAL
    ];

    protected function getAll(): array
    {
        return self::ALL;
    }

}