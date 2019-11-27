<?php
/**
 *  * Created by PhpStorm.
 * User: Dawid Bednarz( dawid@bednarz.pro )
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Entity;

abstract class AbstractToken implements TokenInterface
{
    protected $id;
    protected $value;
    protected $type;
    protected $expired;
    protected $data = [];
    protected $consume = false;

    public function __construct()
    {
        $this->expired = new \DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): TokenInterface
    {
        $this->id = $id;

        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): TokenInterface
    {
        $this->value = $value;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): TokenInterface
    {
        $this->type = $type;

        return $this;
    }

    public function getExpired(): \DateTime
    {
        return $this->expired;
    }

    public function setExpired(\DateTime $expired): TokenInterface
    {
        $this->expired = $expired;

        return $this;
    }

    public function addExpired(\DateInterval $interval): TokenInterface
    {
        $this->expired = (new \DateTime())->add($interval);

        return $this;
    }

    public function isConsume(): bool
    {
        return $this->consume;
    }

    public function setConsume(bool $consume): TokenInterface
    {
        $this->consume = $consume;

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): AbstractToken
    {
        $this->data = $data;

        return $this;
    }
}