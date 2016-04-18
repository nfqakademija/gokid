<?php

namespace AppBundle\Validator\Constraints;

use AppBundle\Entity\Offer;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AgesAscendingValidator extends ConstraintValidator
{

    /**
     * Checks if the passed age values are valid.
     *
     * @param Offer $offer
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($offer, Constraint $constraint)
    {
        if ($offer->getAgeFrom() > $offer->getAgeTo()) {
            $this->context->buildViolation(
                $constraint->message,
                ['id' => 'ages']
            )
                ->addViolation();
        }
    }
}
