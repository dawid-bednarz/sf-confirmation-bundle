<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Entity;

interface TokenInterface
{
    public function getId(): int;

    public function setId(int $id): TokenInterface;

    public function getValue(): string;

    public function setValue(string $value): TokenInterface;

    public function getType(): string;

    public function setType(string $type): TokenInterface;

    public function getExpired(): ?\DateTime;

    public function getData(): array;

    public function setExpired(\DateTime $expired): TokenInterface;

    public function isConsume(): bool;

    public function setConsume(bool $consume): TokenInterface;
}