<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Service;

use DawBed\ConfirmationBundle\Exception\SupportTypeException;

class SupportTypeService
{
    private $types;

    function __construct(array $types)
    {
        $this->types = $types;
    }

    public function check(string $type) : void
    {
       if(!in_array($type, $this->types)) {
           throw new SupportTypeException(sprintf(
               '"%s" type is not supported. Before use type add him to configuration file.',
               $type));
       }
    }
}