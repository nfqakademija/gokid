<?php

namespace AppBundle\Form;

use AppBundle\Entity\OfferImage;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ImageTransformer implements DataTransformerInterface
{

    /**
     * Transforms a value from the original representation to a transformed representation.
     *
     * @param mixed $value The value in the original representation
     *
     * @return mixed The value in the transformed representation
     *
     * @throws TransformationFailedException When the transformation fails.
     */
    public function transform($image)
    {
        return null;
    }

    /**
     * Transforms a value from the transformed representation to its original
     * representation.
     *
     * @param mixed $files The value in the transformed representation
     *
     * @return mixed The value in the original representation
     *
     * @throws TransformationFailedException When the transformation fails.
     */
    public function reverseTransform($images)
    {
        if (is_array($images) && $images[0]) {
            $offerImages = [];
            foreach ($images as $image) {
                $offerImage = new OfferImage();
                $offerImage->setImageFile($image);
                $offerImages[] = $offerImage;
            }
            return $offerImages;
        } elseif (!is_array($images) && $images) {
            $offerImage = new OfferImage();
            $offerImage->setImageFile($images);
            return $offerImage;
        }
        return null;
    }
}
