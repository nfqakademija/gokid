<?php

namespace tests\AppBundle\Entity;

use AppBundle\Entity\Activity;
use AppBundle\Entity\Offer;
use AppBundle\Entity\OfferImage;

/**
 * Class ActivityTest
 * @package tests\AppBundle\Entity
 */
class ActivityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function getTestGetNameData()
    {
        return [
            ['Basketball', 'Basketball'],
            ['Futbolas', 'Futbolas'],
        ];
    }

    /**
     * @param string $inputName
     * @param string $outputName
     *
     * @dataProvider getTestGetNameData()
     */
    public function testGetName($inputName, $outputName)
    {
        $activity = new Activity();
        $activity->setName($inputName);
        $this->assertEquals(
            $outputName,
            $activity->getName()
        );
    }

    /**
     * @return array
     */
    public function getTestDefaultImageData()
    {
        $image = new OfferImage();
        $image->setImageName('futbolas.jpg');

        return [
            [$image, $image],
        ];
    }

    /**
     * @param OfferImage $inputImage
     * @param OfferImage $outputImage
     *
     * @dataProvider getTestDefaultImageData()
     */
    public function testDefaultImage($inputImage, $outputImage)
    {
        $activity = new Activity();
        $activity->setDefaultImage($inputImage);
        $this->assertEquals(
            $outputImage,
            $activity->getDefaultImage()
        );
    }

    /**
     * @return array
     */
    public function getTestGetOffersData()
    {
        $offer1 = new Offer();
        $offer1->setName('Sabonio krepšinio centras');
        $offer2 = new Offer();
        $offer2->setName('Kauno futbolo mokykla „Tauras“');
        $offers = [];
        array_push($offers, $offer1, $offer2);

        return [
            [$offer1, $offer2, $offers],
        ];
    }

    /**
     * @param Offer   $offer1
     * @param Offer   $offer2
     * @param Offer[] $offers
     *
     * @dataProvider getTestGetOffersData()
     */
    public function testGetOffers($offer1, $offer2, $offers)
    {
        $activity = new Activity();
        $activity->addOffer($offer1);
        $activity->addOffer($offer2);

        $this->assertEquals(
            $offers,
            $activity->getOffers()->getValues()
        );
    }

    /**
     * @return array
     */
    public function getTestAddOfferData()
    {
        $offer1 = new Offer();
        $offer1->setName('Sabonio krepšinio centras');

        return [
            [$offer1, $offer1],
        ];
    }

    /**
     * @param Offer $inputOffer
     * @param Offer $outputOffer
     *
     * @dataProvider getTestAddOfferData()
     */
    public function testAddOffer($inputOffer, $outputOffer)
    {
        $activity = new Activity();
        $activity->addOffer($inputOffer);
        $this->assertEquals(
            $outputOffer,
            $activity->getOffers()[0]
        );
    }

    /**
     * @return array
     */
    public function getTestRemoveOfferData()
    {
        $offer1 = new Offer();
        $offer1->setName('Sabonio krepšinio centras');
        $offer2 = new Offer();
        $offer2->setName('Kauno futbolo mokykla „Tauras“');
        $inputActivity = new Activity();

        $inputActivity->addOffer($offer1);
        $inputActivity->addOffer($offer2);
        $outputActivity = clone ($inputActivity);
        $outputOffers = $outputActivity->getOffers()->getValues();
        unset($outputOffers[1]);

        return [
            [$inputActivity, $offer2, $outputOffers],

        ];
    }

    /**
     * @param Activity $inputActivity
     * @param Offer    $offerRemove
     * @param Offer[]  $outputOffers
     *
     * * @dataProvider getTestRemoveOfferData()
     */
    public function testRemoveOffer($inputActivity, $offerRemove, $outputOffers)
    {
        $inputActivity->removeOffer($offerRemove);
        $this->assertEquals(
            $outputOffers,
            $inputActivity->getOffers()->getValues()
        );
    }

    /**
     * @return array
     */
    public function getTestToStringData()
    {
        return [
            ['Basketball'],
        ];
    }

    /**
     * @param string $inputName
     *
     * @dataProvider getTestToStringData()
     */
    public function testToString($inputName)
    {
        $activity = new Activity();
        $activity->setName($inputName);
        $this->assertEquals(
            true,
            is_string($activity->__toString())
        );
    }
}
