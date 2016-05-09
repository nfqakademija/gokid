<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ImageExtensions extends Constraint
{
    public $message;
    protected $extensions = [];
        
    public function __construct($options)
    {
        if (isset($options['extensions'])) {
            $this->extensions = $options['extensions'];
            $this->message = 'Leidžiami failų formatai: [';
            foreach ($this->extensions as $index => $extension) {
                if ($index < sizeof($this->extensions) - 1) {
                    $this->message .= $extension . ', ';
                } else {
                    $this->message .= $extension . ' ]';
                }
            }
        };
        parent::__construct($options);
    }

    public function getTargets()
    {
        return Constraint::PROPERTY_CONSTRAINT;
    }

    public function getExtensions()
    {
        return $this->extensions;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
