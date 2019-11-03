<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Service;

use DawBed\PHPToken\TokenInterface;
use Doctrine\ORM\EntityManagerInterface;

class DeleteService
{
    private $entityManager;

    function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function make(TokenInterface $token): EntityManagerInterface
    {
        $this->entityManager->remove($token);

        return $this->entityManager;
    }
}