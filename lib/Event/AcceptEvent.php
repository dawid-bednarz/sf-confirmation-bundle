<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Event;

use DawBed\ComponentBundle\Event\AbstractResponseEvent;
use DawBed\ConfirmationBundle\Entity\TokenInterface;

class AcceptEvent extends AbstractResponseEvent
{
    private $token;

    function __construct(TokenInterface $token)
    {
        $this->token = $token;
    }

    public function getToken(): TokenInterface
    {
        return $this->token;
    }

    public function getName(): string
    {
        return sprintf('%s%s', Events::ACCEPT_TOKEN, $this->token->getType());
    }

}