<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Event;

use DawBed\ComponentBundle\Event\AbstractEvent;
use DawBed\ConfirmationBundle\Entity\TokenInterface;
use DawBed\ConfirmationBundle\Model\Criteria\TokenCriteria;

class GenerateEvent extends AbstractEvent
{
    protected $setting;
    protected $token;

    function __construct(TokenCriteria $setting)
    {
        $this->setting = $setting;
    }

    public function getSetting(): TokenCriteria
    {
        return $this->setting;
    }

    public function setToken(TokenInterface $token): void
    {
        $this->token = $token;
    }

    public function getToken(): TokenInterface
    {
        return $this->token;
    }

    public function getName(): string
    {
        return Events::GENERATE_TOKEN;
    }

    public function __toString(): string
    {
        return $this::getName();
    }
}