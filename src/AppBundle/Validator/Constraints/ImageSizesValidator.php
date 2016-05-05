<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ImageSizesValidator extends ConstraintValidator
{

    /**
     * Checks uploaded image sizes.
     *
     * @param String $number
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($images, Constraint $constraint)
    {
        if (is_array($images)) {
            foreach ($images as $image) {
                if ($image) {
                    if ($image->getImageFile()->getError() ||
                        $image->getImageFile()->getSize() > $constraint->getMaxSize()
                    ) {
                        $this->context->addViolation(
                            $constraint->getMessage()
                        );
                    }
                }
            }
        } else {
            if ($images && ($images->getImageFile()->getError() ||
                $images->getImageFile()->getSize() > $constraint->getMaxSize())
            ) {
                $this->context->addViolation(
                    $constraint->getMessage()
                );
            }
        }
    }
}
