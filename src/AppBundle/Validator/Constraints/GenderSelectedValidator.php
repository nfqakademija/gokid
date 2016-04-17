<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class GenderSelectedValidator extends ConstraintValidator
{

    /**
     * Checks if user has selected at least one gender.
     *
     * @param Offer $offer The offer that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($offer, Constraint $constraint)
    {
        if (!$offer->isMale() && !$offer->isFemale()) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
