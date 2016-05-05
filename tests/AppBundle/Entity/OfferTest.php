<?php

namespace tests\AppBundle\Entity;

use AppBundle\Entity\Activity;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Offer;
use AppBundle\Entity\OfferImage;
use AppBundle\Entity\User;

/**
 * Class OfferTest
 * @package tests\AppBundle\Entity
 */
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
     * @param string $inputInfo
     * @param string $outputInfo
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
            [false, false],
        ];
    }

    /**
     * @param boolean $input
     * @param boolean $output
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
            [22.4, 22.4],
        ];
    }

    /**
     * @param mixed $inputDistance
     * @param mixed $outputDistance
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
     * @param string $inputAddress
     * @param string $outputAddress
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
    public function getTestGetRatingData()
    {
        return [
            [4.5, 4.5],
        ];
    }

    /**
     * @param float $inputRating
     * @param float $outputRating
     *
     * @dataProvider getTestGetRatingData()
     */
    public function testGetRating($inputRating, $outputRating)
    {
        $offer = new Offer();
        $offer->setRating($inputRating);
        $this->assertEquals(
            $outputRating,
            $offer->getRating()
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
     * @param string $inputName
     * @param string $outputName
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
     * @param string $inputDescription
     * @param string $outputDescription
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
    public function getTestGetAgeFromData()
    {
        return [
            [12, 12],
        ];
    }

    /**
     * @param int $inputAge
     * @param int $outputAge
     *
     * @dataProvider getTestAgeFromData()
     */
    public function testGetAgeFrom($inputAge, $outputAge)
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
    public function getTestGetAgeToData()
    {
        return [
            [14, 14],
        ];
    }

    /**
     * @param int $inputAge
     * @param int $outputAge
     *
     * @dataProvider getTestGetAgeToData()
     */
    public function testGetAgeTo($inputAge, $outputAge)
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
     * @param float $inputPrice
     * @param float $outputPrice
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
     * @param Activity $inputActivity
     * @param Activity $outputActivity
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
     * @param User $inputUser
     * @param User $outputUser
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
            [false, false],
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
            [false, false],
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
     * @param float $inputLatitude
     * @param float $outputLatitude
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
     * @param float $inputLongitude
     * @param float $outputLongitude
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
     * @param OfferImage[] $inputImages
     * @param OfferImage[] $outputImages
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
     * @param OfferImage $inputImage
     * @param OfferImage $outputImage
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
            [2, Offer::MONTHLY],
        ];
    }

    /**
     * @param mixed $inputPayment
     * @param mixed $outputPayment
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

    /**
     * @return array
     */
    public function getTestGetCommentsData()
    {
        $comment1 = new Comment();
        $comment1->setTitle('Geras būrelis');
        $comment2 = new Comment();
        $comment2->setName('Puikus būrelis');
        $comments = [];
        array_push($comments, $comment1, $comment2);

        return [
            [$comment1, $comment2, $comments],
        ];
    }

    /**
     * @param Comment   $comment1
     * @param Comment   $comment2
     * @param Comment[] $comments
     *
     * @dataProvider getTestGetCommentsData()
     */
    public function testGetComments($comment1, $comment2, $comments)
    {
        $offer = new Offer();
        $offer->addComment($comment1);
        $offer->addComment($comment2);

        $this->assertEquals(
            $comments,
            $offer->getComments()->getValues()
        );
    }

    /**
     * @return array
     */
    public function getTestAddCommentData()
    {
        $comment1 = new Comment();
        $comment1->setTitle('Geras būrelis');

        return [
            [$comment1, $comment1],
        ];
    }

    /**
     * @param Comment $inputComment
     * @param Comment $outputComment
     *
     * @dataProvider getTestAddCommentData()
     */
    public function testAddComment($inputComment, $outputComment)
    {
        $offer = new Offer();
        $offer->addComment($inputComment);
        $this->assertEquals(
            $outputComment,
            $offer->getComments()[0]
        );
    }

    /**
     * @return array
     */
    public function getTestRemoveCommentData()
    {
        $comment1 = new Comment();
        $comment1->setTitle('Geras būrelis');
        $comment2 = new Comment();
        $comment2->setName('Puikus būrelis');
        $inputOffer = new Offer();

        $inputOffer->addComment($comment1);
        $inputOffer->addComment($comment2);
        $outputOffer = clone ($inputOffer);
        $outputComments = $outputOffer->getComments()->getValues();
        unset($outputComments[1]);

        return [
            [$inputOffer, $comment2, $outputComments],
        ];
    }

    /**
     * @param Offer     $inputOffer
     * @param Comment   $commentRemove
     * @param Comment[] $outputComments
     *
     * * @dataProvider getTestRemoveCommentData()
     */
    public function testRemoveComment($inputOffer, $commentRemove, $outputComments)
    {
        $inputOffer->removeComment($commentRemove);
        $this->assertEquals(
            $outputComments,
            $inputOffer->getComments()->getValues()
        );
    }
}
