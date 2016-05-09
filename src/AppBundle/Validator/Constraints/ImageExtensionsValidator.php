<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ImageExtensionsValidator extends ConstraintValidator
{
    /**
     * Checks uploaded image extensions.
     *
     * @param String $number
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($images, Constraint $constraint)
    {
        if (($extensions = $constraint->getExtensions()) && $images) {
            if (is_array($images) && $images[0]) {
                foreach ($images as $image) {
                    if (!in_array(
                        strtolower(
                            $image->getImageFile()->getClientOriginalExtension()
                        ),
                        $extensions
                    )) {
                        $this->context->addViolation(
                            $constraint->getMessage()
                        );
                    }
                }
            } else {
                if (!in_array(
                    strtolower(
                        $images->getImageFile()->getClientOriginalExtension()
                    ),
                    $extensions
                )) {
                    $this->context->addViolation(
                        $constraint->getMessage()
                    );
                }
            }
        }
    }
}
