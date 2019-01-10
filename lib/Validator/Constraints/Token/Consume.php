<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Validator\Constraints\Token;

use Symfony\Component\Validator\Constraint;

class Consume  extends Constraint
{
    public $message = 'token.isConsumed';

    public function validatedBy()
    {
        return ConsumeValidator::class;
    }
}