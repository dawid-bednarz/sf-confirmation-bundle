<?php
/**
 * User: Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Model;

use DawBed\PHPToken\TokenInterface;

class CreateModel
{
    private $entity;
    private $dateInterval;

    function __construct(TokenInterface $token, \DateInterval $dateInterval)
    {
        $this->entity = $token;
        $this->dateInterval = $dateInterval;
    }

    public function getEntity(): ?TokenInterface
    {
        return $this->entity;
    }

    public function make(): TokenInterface
    {
        $this->entity->addExpired($this->dateInterval);
        $this->entity
            ->setValue($this->generateValue());

        return $this->entity;
    }

    private function generateValue(): string
    {
        return uniqid(time(), true);
    }
}