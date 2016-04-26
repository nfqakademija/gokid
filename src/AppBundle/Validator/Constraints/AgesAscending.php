<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class AgesAscending extends Constraint
{
    public $message = "Vaikų amžių rėžiai įvesti neteisingai";

    public function getTargets()
    {
        return Constraint::CLASS_CONSTRAINT;
    }
}
