<?php
/**
 * Created by PhpStorm.
 * User: rimas
 * Date: 5/3/16
 * Time: 11:41 AM
 */

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\User;
use AppBundle\Entity\Offer;

class UserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function getTestGetFirstNameData()
    {
        return [
            ['Darius', 'Darius'],
            ['', '']
        ];
    }

    /**
     * @param $inputFirstName
     * @param $outputFirstName
     *
     * @dataProvider getTestGetFirstNameData()
     */
    public function testGetFirstName($inputFirstName, $outputFirstName)
    {
        $user = new User();
        $user->setFirstName($inputFirstName);
        $this->assertEquals(
            $outputFirstName,
            $user->getFirstName()
        );
    }

    /**
     * @return array
     */
    public function getTestGetLastNameData()
    {
        return [
            ['Sirtautas', 'Sirtautas'],
            ['', '']
        ];
    }

    /**
     * @param $inputLastName
     * @param $outputLastName
     *
     * @dataProvider getTestGetLastNameData()
     */
    public function testGetLastName($inputLastName, $outputLastName)
    {
        $user = new User();
        $user->setLastName($inputLastName);
        $this->assertEquals(
            $outputLastName,
            $user->getLastName()
        );
    }

    /**
     * @return array
     */
    public function getTestGetPhoneData()
    {
        return [
            ['8 686 37833', '8 686 37833'],
            ['+370 657 78030', '+370 657 78030']
        ];
    }

    /**
     * @param $inputPhone
     * @param $outputPhone
     *
     * @dataProvider getTestGetPhoneData()
     */
    public function testGetPhone($inputPhone, $outputPhone)
    {
        $user = new User();
        $user->setPhone($inputPhone);
        $this->assertEquals(
            $outputPhone,
            $user->getPhone()
        );
    }

    /**
     * @return array
     */
    public function getTestGetRatingData()
    {
        return [
            ['5', '5'],
            ['2', '2']
        ];
    }

    /**
     * @param $inputRating
     * @param $outputRating
     *
     * @dataProvider getTestGetRatingData()
     */
    public function testGetRating($inputRating, $outputRating)
    {
        $user = new User();
        $user->setRating($inputRating);
        $this->assertEquals(
            $outputRating,
            $user->getRating()
        );
    }

    /**
     * @return array
     */
    public function getTestGetCurrentPasswordData()
    {
        return [
            ['password', 'password']
        ];
    }

    /**
     * @param $inputCurrentPassword
     * @param $outputCurrentPassword
     *
     * @dataProvider getTestGetCurrentPasswordData()
     */
    public function testGetCurrentPassword($inputCurrentPassword, $outputCurrentPassword)
    {
        $user = new User();
        $user->setCurrentPassword($inputCurrentPassword);
        $this->assertEquals(
            $outputCurrentPassword,
            $user->getCurrentPassword()
        );
    }

    /**
     * @return array
     */
    public function getTestGetOffersData()
    {
        $offer1 = new Offer();
        $offer1->setName('Offer1');
        $offer2 = new Offer();
        $offer2->setName('Offer2');
        $offers = [];
        array_push($offers, $offer1, $offer2);

        return [
            [$offer1, $offer2, $offers],
        ];
    }

    /**
     * @param $offer1
     * @param $offer2
     * @param $offers
     *
     * @dataProvider getTestGetOffersData()
     */
    public function testGetOffers($offer1, $offer2, $offers)
    {
        $user = new User();
        $user->addOffer($offer1);
        $user->addOffer($offer2);

        $this->assertEquals(
            $offers,
            $user->getOffers()->getValues()
        );
    }

    /**
     * @return array
     */
    public function getTestAddOfferData()
    {
        $offer1 = new Offer();
        $offer1->setName('Offer1');

        return [
            [$offer1, $offer1],
        ];
    }

    /**
     * @param $inputOffer
     * @param $outputOffer
     *
     * @dataProvider getTestAddOfferData()
     */
    public function testAddOffer($inputOffer, $outputOffer)
    {
        $user = new User();
        $user->addOffer($inputOffer);
        $this->assertEquals(
            $outputOffer,
            $user->getOffers()[0]
        );
    }

    /**
     * @return array
     */
    public function getTestRemoveOfferData()
    {
        $offer1 = new Offer();
        $offer1->setName('Offer1');
        $offer2 = new Offer();
        $offer2->setName('Offer2');
        $inputUser = new User();

        $inputUser->addOffer($offer1);
        $inputUser->addOffer($offer2);
        $outputUser = clone ($inputUser);
        $outputOffers = $outputUser->getOffers()->getValues();
        unset($outputOffers[1]);

        return [
            [$inputUser, $offer2, $outputOffers],

        ];
    }

    /**
     * @param $inputUser
     * @param $offerRemove
     * @param $outputOffers
     *
     * * @dataProvider getTestRemoveOfferData()
     */
    public function testRemoveOffer($inputUser, $offerRemove, $outputOffers)
    {
        $inputUser->removeOffer($offerRemove);
        $this->assertEquals(
            $outputOffers,
            $inputUser->getOffers()->getValues()
        );
    }
}
