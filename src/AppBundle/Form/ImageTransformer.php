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
    public function transform($offer)
    {
        return $offer;
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
    public function reverseTransform($offer)
    {
        $images = [];
        if ($offer->getImages() && $offer->getImages()[0]) {
            foreach ($offer->getImages() as $file) {
                $image = new OfferImage();
                $image->setImageFile($file);
                $image->setOffer($offer);
                $images[] = $image;
            }
            $offer->setImages($images);
        } else {
            $offer->setImages(null);
        }
        return $offer;
    }
}
