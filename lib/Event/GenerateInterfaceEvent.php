<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Event;

use DawBed\ConfirmationBundle\Entity\TokenInterface;

interface GenerateInterfaceEvent
{
    public function setToken(TokenInterface $token): void;

    public function getToken(): TokenInterface;

    public function getType(): string;

    public function getExpiredInterval(): \DateInterval;
}