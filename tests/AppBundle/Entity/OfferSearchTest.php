<?php

namespace tests\AppBundle\Entity;

use AppBundle\Entity\OfferSearch;

/**
 * Class OfferSearchTest
 * @package tests\AppBundle\Entity
 */
class OfferSearchTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function getTestGetDistanceData()
    {
        return [
            [10, 10],
            [10.1, 10.1],
            [null, null],
            ['5.1', 5.1],
            ['5.1', '5.1'],
        ];
    }

    /**
     * @param int $inputDistance
     * @param int $outputDistance
     *
     * @dataProvider getTestGetDistanceData()
     */
    public function testGetDistance($inputDistance, $outputDistance)
    {
        $offer = new OfferSearch();
        $offer->setDistance($inputDistance);
        $this->assertEquals(
            $outputDistance,
            $offer->getDistance()
        );
    }

    /**
     * @return array
     */
    public function getTestGetPriceFromData()
    {
        return [
            [5, 5],
            [null, null],
            ['5', '5'],
            ['5', 5],
        ];
    }

    /**
     * @param int $inputPriceFrom
     * @param int $outputPriceFrom
     *
     * @dataProvider getTestGetPriceFromData()
     */
    public function testGetPriceFrom($inputPriceFrom, $outputPriceFrom)
    {
        $offer = new OfferSearch();
        $offer->setPriceFrom($inputPriceFrom);
        $this->assertEquals(
            $outputPriceFrom,
            $offer->getPriceFrom()
        );
    }

    /**
     * @return array
     */
    public function getTestGetPriceToData()
    {
        return [
            [25, 25],
            [null, null],
            ['25', '25'],
            ['25', 25],
        ];
    }

    /**
     * @param int $inputPriceTo
     * @param int $outputPriceTo
     *
     * @dataProvider getTestGetPriceToData()
     */
    public function testGetPriceTo($inputPriceTo, $outputPriceTo)
    {
        $offer = new OfferSearch();
        $offer->setPriceTo($inputPriceTo);
        $this->assertEquals(
            $outputPriceTo,
            $offer->getPriceTo()
        );
    }

    /**
     * @return array
     */
    public function getTestGetAgeData()
    {
        return [
            [12, 12],
            [null, null],
            ['12', '12'],
            ['12', 12],
        ];
    }

    /**
     * @param int $inputAge
     * @param int $outputAge
     *
     * @dataProvider getTestGetAgeData()
     */
    public function testGetAge($inputAge, $outputAge)
    {
        $offer = new OfferSearch();
        $offer->setAge($inputAge);
        $this->assertEquals(
            $outputAge,
            $offer->getAge()
        );
    }

    /**
     * @return array
     */
    public function getTestGetAddressData()
    {
        return [
            ['Savanorių pr. 223, Kaunas', 'Savanorių pr. 223, Kaunas'],
            [null, null],
        ];
    }

    /**
     * @param string $inputAddress
     * @param string $outputAddress
     *
     * @dataProvider getTestGetAddressData()
     */
    public function testGetAddress($inputAddress, $outputAddress)
    {
        $offer = new OfferSearch();
        $offer->setAddress($inputAddress);
        $this->assertEquals(
            $outputAddress,
            $offer->getAddress()
        );
    }

    /**
     * @return array
     */
    public function getTestGetActivityData()
    {
        return [
            [3, 3],
            [null, null],
            ['3', '3'],
            ['3', 3],
        ];
    }

    /**
     * @param int $inputActivity
     * @param int $outputActivity
     *
     * @dataProvider getTestGetActivityData()
     */
    public function testGetActivity($inputActivity, $outputActivity)
    {
        $offer = new OfferSearch();
        $offer->setActivity($inputActivity);
        $this->assertEquals(
            $outputActivity,
            $offer->getActivity()
        );
    }

    /**
     * @return array
     */
    public function getTestGetLatitudeData()
    {
        return [
            [114.25, 114.25],
            ['114.25', '114.25'],
            ['114.25', 114.25],
            [null, null],
        ];
    }

    /**
     * @param float $inputLatitude
     * @param float $outputLatitude
     *
     * @dataProvider getTestGetLatitudeData()
     */
    public function testGetLatitude($inputLatitude, $outputLatitude)
    {
        $offer = new OfferSearch();
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
            ['84.5', '84.5'],
            ['84.5', 84.5],
            [null, null],
        ];
    }

    /**
     * @param float $inputLongitude
     * @param float $outputLongitude
     *
     * @dataProvider getTestGetLongitudeData()
     */
    public function testGetLongitude($inputLongitude, $outputLongitude)
    {
        $offer = new OfferSearch();
        $offer->setLongitude($inputLongitude);
        $this->assertEquals(
            $outputLongitude,
            $offer->getLongitude()
        );
    }

    /**
     * @return array
     */
    public function getTestIsMaleData()
    {
        return [
            [true, true],
            [false, false],
            [null, null],
        ];
    }

    /**
     * @param boolean $input
     * @param boolean $output
     *
     * @dataProvider getTestIsMaleData()
     */
    public function testIsMale($input, $output)
    {
        $offer = new OfferSearch();
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
            [false, false],
            [null, null],
        ];
    }

    /**
     * @param boolean $input
     * @param boolean $output
     *
     * @dataProvider getTestIsFemaleData()
     */
    public function testIsFemale($input, $output)
    {
        $offer = new OfferSearch();
        $offer->setFemale($input);
        $this->assertEquals(
            $output,
            $offer->isFemale()
        );
    }
}
