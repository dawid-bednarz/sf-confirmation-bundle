<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Service\Token;

class SupportTypeService
{
    private $types;

    function __construct(array $types)
    {
        $this->types = $types;
    }

    public function check(string $type)
    {
        return in_array($type, $this->types);
    }
}