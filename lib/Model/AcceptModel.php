<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Model;

use DawBed\ConfirmationBundle\Entity\TokenInterface;

class AcceptModel
{
    private $entity;

    public function getEntity(): ?TokenInterface
    {
        return $this->entity;
    }

    public function setEntity($entity): AcceptModel
    {
        $this->entity = $entity;

        return $this;
    }

    public function hasEntity()
    {
        return !is_null($this->entity);
    }

    public function make(): TokenInterface
    {
        $this->entity->setConsume(true);

        return $this->entity;
    }

}