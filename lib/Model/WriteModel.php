<?php
/**
 * User: Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Model;

use DawBed\ConfirmationBundle\Entity\TokenInterface;
use DateInterval;

class WriteModel
{
    private TokenInterface $entity;
    private DateInterval $dateInterval;
    private bool $consume = false;

    public static function consumedInstance(?TokenInterface $token = null): WriteModel
    {
        $model = new self;
        $model->entity = $token;
        $model->consume = true;

        return $model;
    }

    public static function baseInstance(TokenInterface $token, DateInterval $dateInterval): WriteModel
    {
        $model = new self;
        $model->entity = $token;
        $model->dateInterval = $dateInterval;

        return $model;
    }

    public function getEntity(): ?TokenInterface
    {
        return $this->entity;
    }

    public function setConsume(bool $consume): void
    {
        $this->consume = $consume;
    }

    public function hasEntity(): bool
    {
        return !is_null($this->entity);
    }

    public function make(): TokenInterface
    {
        if ($this->consume) {
            $this->entity->setConsume($this->consume);
        } else {
            $this->entity->addExpired($this->dateInterval)
                ->setValue($this->generateValue());
        }
        return $this->entity;
    }

    private function generateValue(): string
    {
        return uniqid() . uniqid() . uniqid();
    }
}