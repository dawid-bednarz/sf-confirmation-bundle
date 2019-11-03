<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Event;

use DawBed\ConfirmationBundle\Entity\TokenInterface;
use DawBed\ConfirmationBundle\Model\Criteria\TokenCriteria;

class RefreshEvent extends GenerateEvent
{
    function __construct(TokenInterface $oldToken, TokenCriteria $tokenSetting)
    {
        parent::__construct($tokenSetting);
        $this->setToken($oldToken);
    }

    public function getName(): string
    {
        return Events::REFRESH_TOKEN;
    }
}