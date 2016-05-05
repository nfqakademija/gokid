<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ImageSizes extends Constraint
{
    public $message;
    protected $maxSize;

    public function __construct($options)
    {
        if (isset($options['maxSize'])) {
            $this->maxSize = $options['maxSize'];
            $this->message = 'Paveikslėlių maksimalus dydis ' .
                $this->maxSize / 1048576 . 'MB';
        };
        parent::__construct($options);
    }

    public function getTargets()
    {
        return Constraint::PROPERTY_CONSTRAINT;
    }

    public function getMaxSize()
    {
        return $this->maxSize;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
