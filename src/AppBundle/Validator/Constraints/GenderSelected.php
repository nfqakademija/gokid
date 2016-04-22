<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 16.4.16
 * Time: 15.24
 */

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class GenderSelected extends Constraint
{
    public $message = "Prašome pasirinkti bent vieną lytį";

    public function getTargets()
    {
        return Constraint::CLASS_CONSTRAINT;
    }
}
