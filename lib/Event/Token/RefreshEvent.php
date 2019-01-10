<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Event\Token;

use DawBed\ConfirmationBundle\Event\Events;
use DawBed\PHPToken\DTO\TokenSetting;
use DawBed\PHPToken\TokenInterface;

class RefreshEvent extends GenerateEvent
{
    function __construct(TokenInterface $oldToken, TokenSetting $tokenSetting)
    {
        parent::__construct($tokenSetting);
        $this->setToken($oldToken);
    }

    public function getName(): string
    {
        return Events::REFRESH_TOKEN;
    }
}