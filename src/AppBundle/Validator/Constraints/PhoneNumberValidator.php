<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PhoneNumberValidator extends ConstraintValidator
{

    /**
     * Checks if the passed phone number is valid.
     *
     * @param String $number
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($number, Constraint $constraint)
    {
        if (!preg_match("/^(\+)*[0-9]*$/", $number)) {
            $this->context->buildViolation(
                $constraint->message,
                ['id' => 'phone']
            )
                ->addViolation();
        }
    }
}
