<?php

namespace tests\AppBundle\Entity;

use AppBundle\Entity\Activity;
use AppBundle\Entity\Offer;
use AppBundle\Entity\OfferImage;
use AppBundle\Entity\User;

class OfferTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function getTestGetContactInfoData()
    {
        return [
            ['Vardas pavardė tel. 8686 00001', 'Vardas pavardė tel. 8686 00001'],
        ];
    }

    /**
     * @param $inputInfo
     * @param $outputInfo
     *
     * @dataProvider getTestGetContactInfoData()
     */
    public function testGetContactInfo($inputInfo, $outputInfo)
    {
        $offer = new Offer();
        $offer->setContactInfo($inputInfo);
        $this->assertEquals(
            $outputInfo,
            $offer->getContactInfo()
        );
    }

    /**
     * @return array
     */
    public function getTestIsImportedData()
    {
        return [
            [true, true],
            [false, false]
        ];
    }

    /**
     * @param $input
     * @param $output
     *
     * @dataProvider getTestIsImportedData()
     */
    public function testIsImported($input, $output)
    {
        $offer = new Offer();
        $offer->setImported($input);
        $this->assertEquals(
            $output,
            $offer->isImported()
        );
    }

    /**
     * @return array
     */
    public function getTestGetDistanceData()
    {
        return [
            [20, 20],
            [22.4, 22.4]
        ];
    }

    /**
     * @param $inputDistance
     * @param $outputDistance
     *
     * @dataProvider getTestGetDistanceData()
     */
    public function testGetDistance($inputDistance, $outputDistance)
    {
        $offer = new Offer();
        $offer->setDistance($inputDistance);
        $this->assertEquals(
            $outputDistance,
            $offer->getDistance()
        );
    }

    /**
     * @return array
     */
    public function getTestGetAddressData()
    {
        return [
            ['Savanorių pr. 223, Kaunas', 'Savanorių pr. 223, Kaunas'],
        ];
    }

    /**
     * @param $inputAddress
     * @param $outputAddress
     *
     * @dataProvider getTestGetAddressData()
     */
    public function testGetAddress($inputAddress, $outputAddress)
    {
        $offer = new Offer();
        $offer->setAddress($inputAddress);
        $this->assertEquals(
            $outputAddress,
            $offer->getAddress()
        );
    }

    /**
     * @return array
     */
    public function getTestGetNameData()
    {
        return [
            ['Sabonio krepšinio centras', 'Sabonio krepšinio centras'],
        ];
    }

    /**
     * @param $inputName
     * @param $outputName
     *
     * @dataProvider getTestGetNameData()
     */
    public function testGetName($inputName, $outputName)
    {
        $offer = new Offer();
        $offer->setName($inputName);
        $this->assertEquals(
            $outputName,
            $offer->getName()
        );
    }

    /**
     * @return array
     */
    public function getTestGetDescriptionData()
    {
        $description = <<<DESCRIPTION
Strateginis krepšinio rinkos partneris, ugdantis aktyvius ir sveikus visuomenės narius,
 lyderiaujantis rengiant profesionalaus krepšinio pamainą.
DESCRIPTION;
        return [
            [$description, $description],
        ];
    }

    /**
     * @param $inputDescription
     * @param $outputDescription
     *
     * @dataProvider getTestGetDescriptionData()
     */
    public function testGetDescription($inputDescription, $outputDescription)
    {
        $offer = new Offer();
        $offer->setDescription($inputDescription);
        $this->assertEquals(
            $outputDescription,
            $offer->getDescription()
        );
    }

    /**
     * @return array
     */
    public function getTestAgeFromData()
    {
        return [
            [12, 12],
        ];
    }

    /**
     * @param $inputAge
     * @param $outputAge
     *
     * @dataProvider getTestAgeFromData()
     */
    public function testAgeFrom($inputAge, $outputAge)
    {
        $offer = new Offer();
        $offer->setAgeFrom($inputAge);
        $this->assertEquals(
            $outputAge,
            $offer->getAgeFrom()
        );
    }

    /**
     * @return array
     */
    public function getTestAgeToData()
    {
        return [
            [14, 14],
        ];
    }

    /**
     * @param $inputAge
     * @param $outputAge
     *
     * @dataProvider getTestAgeToData()
     */
    public function testAgeTo($inputAge, $outputAge)
    {
        $offer = new Offer();
        $offer->setAgeTo($inputAge);
        $this->assertEquals(
            $outputAge,
            $offer->getAgeTo()
        );
    }

    /**
     * @return array
     */
    public function getTestGetPriceData()
    {
        return [
            [14.25, 14.25],
        ];
    }

    /**
     * @param $inputPrice
     * @param $outputPrice
     *
     * @dataProvider getTestGetPriceData()
     */
    public function testGetPrice($inputPrice, $outputPrice)
    {
        $offer = new Offer();
        $offer->setPrice($inputPrice);
        $this->assertEquals(
            $outputPrice,
            $offer->getPrice()
        );
    }

    /**
     * @return array
     */
    public function getTestGetActivityData()
    {
        $activity = new  Activity();
        $activity->setName('Krepšinis');
        return [
            [$activity, $activity],
            [null, null],
        ];
    }

    /**
     * @param $inputActivity
     * @param $outputActivity
     *
     * @dataProvider getTestGetActivityData()
     */
    public function testGetActivity($inputActivity, $outputActivity)
    {
        $offer = new Offer();
        $offer->setActivity($inputActivity);
        $this->assertEquals(
            $outputActivity,
            $offer->getActivity()
        );
    }

    /**
     * @return array
     */
    public function getTestGetUserData()
    {
        $user = new  User();
        $user->setFirstName('Darius');
        return [
            [$user, $user],
            [null, null],
        ];
    }

    /**
     * @param $inputUser
     * @param $outputUser
     *
     * @dataProvider getTestGetUserData()
     */
    public function testGetUser($inputUser, $outputUser)
    {
        $offer = new Offer();
        $offer->setUser($inputUser);
        $this->assertEquals(
            $outputUser,
            $offer->getUser()
        );
    }

    /**
     * @return array
     */
    public function getTestIsMaleData()
    {
        return [
            [true, true],
            [false, false]
        ];
    }

    /**
     * @param $input
     * @param $output
     *
     * @dataProvider getTestIsMaleData()
     */
    public function testIsMale($input, $output)
    {
        $offer = new Offer();
        $offer->setMale($input);
        $this->assertEquals(
            $output,
            $offer->isMale()
        );
    }

    /**
     * @return array
     */
    public function getTestIsFemaleData()
    {
        return [
            [true, true],
            [false, false]
        ];
    }

    /**
     * @param $input
     * @param $output
     *
     * @dataProvider getTestIsFemaleData()
     */
    public function testIsFemale($input, $output)
    {
        $offer = new Offer();
        $offer->setFemale($input);
        $this->assertEquals(
            $output,
            $offer->isFemale()
        );
    }

    /**
     * @return array
     */
    public function getTestGetLatitudeData()
    {
        return [
            [114.25, 114.25],
        ];
    }

    /**
     * @param $inputLatitude
     * @param $outputLatitude
     *
     * @dataProvider getTestGetLatitudeData()
     */
    public function testGetLatitude($inputLatitude, $outputLatitude)
    {
        $offer = new Offer();
        $offer->setLatitude($inputLatitude);
        $this->assertEquals(
            $outputLatitude,
            $offer->getLatitude()
        );
    }

    /**
     * @return array
     */
    public function getTestGetLongitudeData()
    {
        return [
            [84.5, 84.5],
        ];
    }

    /**
     * @param $inputLongitude
     * @param $outputLongitude
     *
     * @dataProvider getTestGetLongitudeData()
     */
    public function testGetLongitude($inputLongitude, $outputLongitude)
    {
        $offer = new Offer();
        $offer->setLongitude($inputLongitude);
        $this->assertEquals(
            $outputLongitude,
            $offer->getLongitude()
        );
    }

    /**
     * @return array
     */
    public function getTestGetImagesData()
    {
        $image1 = new OfferImage();
        $image1->setImageName('sabonio.png');

        $image2 = new OfferImage();
        $image2->setImageName('tornadas.jpg');

        $images[] = new OfferImage();
        array_push($images, $image1, $image2);
        return [
            [$images, $images],
        ];
    }

    /**
     * @param $inputImages
     * @param $outputImages
     *
     * @dataProvider getTestGetImagesData()
     */
    public function testGetImages($inputImages, $outputImages)
    {
        $offer = new Offer();
        $offer->setImages($inputImages);
        $this->assertEquals(
            $outputImages,
            $offer->getImages()
        );
    }

    /**
     * @return array
     */
    public function getTestGetMainImageData()
    {
        $image = new OfferImage();
        $image->setImageName('sabonio.png');

        return [
            [$image, $image],
        ];
    }

    /**
     * @param $inputImage
     * @param $outputImage
     *
     * @dataProvider getTestGetMainImageData()
     */
    public function testGetMainImage($inputImage, $outputImage)
    {
        $offer = new Offer();
        $offer->setMainImage($inputImage);
        $this->assertEquals(
            $outputImage,
            $offer->getMainImage()
        );
    }

    /**
     * @return array
     */
    public function getTestGetPaymentTypeData()
    {
        return [
            [0, Offer::SINGLE_TIME],
            [1, Offer::WEEKLY],
            [2, Offer::MONTHLY]
        ];
    }

    /**
     * @param $inputPayment
     * @param $outputPayment
     *
     * @dataProvider getTestGetPaymentTypeData()
     */
    public function testGetPaymentType($inputPayment, $outputPayment)
    {
        $offer = new Offer();
        $offer->setPaymentType($inputPayment);
        $this->assertEquals(
            $outputPayment,
            $offer->getPaymentType()
        );
    }
}
