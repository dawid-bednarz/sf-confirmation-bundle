<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Validator\Constraints\Token;

use DawBed\ConfirmationBundle\Entity\AbstractToken;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ConsumeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if ($value instanceof AbstractToken) {
            $value = $value->isConsume();
        }
        if ($value === true) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}