<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\EventListener;

class TokenIsAlreadyConsumedException extends \Exception
{
    public $message = 'token.isConsumed';

    public function setMessage(string $content)
    {
        $this->message = $content;
    }
}