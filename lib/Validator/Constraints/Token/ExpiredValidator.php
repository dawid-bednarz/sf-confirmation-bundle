<?php
/**
 *  * Dawid Bednarz( dawid@bednarz.pro )
 * Read README.md file for more information and licence uses
 */
declare(strict_types=1);

namespace DawBed\ConfirmationBundle\Validator\Constraints\Token;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ExpiredValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if ($value < new \DateTime()) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}