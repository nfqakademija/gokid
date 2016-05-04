<?php

namespace tests\AppBundle\Entity;

use AppBundle\Entity\Offer;
use AppBundle\Entity\OfferImage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class OfferImageTest
 * @package tests\AppBundle\Entity
 */
class OfferImageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function getTestGetImageNameData()
    {
        return [
            ['sabonio.png', 'sabonio.png'],
        ];
    }

    /**
     * @param string $inputName
     * @param string $outputName
     *
     * @dataProvider getTestGetImageNameData()
     */
    public function testGetImageName($inputName, $outputName)
    {
        $image = new OfferImage();
        $image->setImageName($inputName);
        $this->assertEquals(
            $outputName,
            $image->getImageName()
        );
    }

    /**
     * @return array
     */
    public function getTestGetImageFileData()
    {
        $image = fopen(__DIR__.'/../../../app/Resources/images/offerImages/futbolas.jpg', 'r');

        return [
            [$image, $image],
        ];
    }

    /**
     * @param resource     $inputImage
     * @param UploadedFile $outputImage
     *
     * @dataProvider getTestGetImageFileData()
     */
    public function testGetImageFile($inputImage, $outputImage)
    {
        $image = new OfferImage();
        $image->setImageFile($inputImage);
        $this->assertEquals(
            $outputImage,
            $image->getImageFile()
        );
    }

    /**
     * @return array
     */
    public function getTestGetOfferData()
    {
        $offer = new  Offer();
        $offer->setName('Sabonio krepšinio mokykla');

        return [
            [$offer, $offer],
        ];
    }

    /**
     * @param Offer $inputOffer
     * @param Offer $outputOffer
     *
     * @dataProvider getTestGetOfferData()
     */
    public function testGetOffer($inputOffer, $outputOffer)
    {
        $image = new OfferImage();
        $image->setOffer($inputOffer);
        $this->assertEquals(
            $outputOffer,
            $image->getOffer()
        );
    }

    /**
     * @return array
     */
    public function getTestToStringData()
    {
        return [
            ['sabonio.png'],
        ];
    }

    /**
     * @param string $inputName
     *
     * @dataProvider getTestToStringData()
     */
    public function testToString($inputName)
    {
        $image = new OfferImage();
        $image->setImageName($inputName);
        $this->assertEquals(
            true,
            is_string($image->__toString())
        );
    }
}
