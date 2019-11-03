<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Event;

use DawBed\ComponentBundle\Event\Error\FormErrorEvent;
use DawBed\ConfirmationBundle\Entity\TokenInterface;
use Symfony\Component\Form\Form;

class ErrorEvent extends FormErrorEvent
{
    private $token;
    private $isExpired = false;

    function __construct(TokenInterface $token, Form $form)
    {
        $this->token = $token;
        if ($token->getExpired() < new \DateTime()) {
            $this->isExpired = true;
        }
        parent::__construct(sprintf('%s%s', Events::ERROR_ACCEPT_TOKEN, $token->getType()), $form);
    }

    public function isConsumed(): bool
    {
        return $this->token->isConsume();
    }

    public function isExpired(): bool
    {
        return $this->isExpired;
    }

    public function getMessage(): string
    {
        $errors = $this->form->getErrors(true);

        if ($errors->offsetExists(0)) {
            return $this->form->getErrors(true)->offsetGet(0)->getMessage();
        }
        return 'token.invalid';
    }
}