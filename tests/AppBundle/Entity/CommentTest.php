<?php

namespace tests\AppBundle\Entity;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Offer;

/**
 * Class CommentTest
 * @package tests\AppBundle\Entity
 */
class CommentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function getTestGetOfferData()
    {
        $offer = new Offer();
        $offer->setName('Sabonio krepšinio centras');

        return [
            [$offer, $offer],
            [null, null],
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
        $comment = new Comment();
        $comment->setOffer($inputOffer);
        $this->assertEquals(
            $outputOffer,
            $comment->getOffer()
        );
    }

    /**
     * @return array
     */
    public function getTestGetCreatedAtData()
    {
        $createdAt = new \DateTime();

        return [
            [$createdAt, $createdAt],
        ];
    }

    /**
     * @param \DateTime $inputCreatedAt
     * @param \DateTime $outputCreatedAt
     *
     * @dataProvider getTestGetCreatedAtData()
     */
    public function testGetCreatedAt($inputCreatedAt, $outputCreatedAt)
    {
        $comment = new Comment();
        $comment->setCreatedAt($inputCreatedAt);
        $this->assertEquals(
            $outputCreatedAt,
            $comment->getCreatedAt()
        );
    }

    /**
     * @return array
     */
    public function getTestGetTitleData()
    {
        return [
            ['Geras būrelis', 'Geras būrelis'],
        ];
    }

    /**
     * @param mixed $inputTitle
     * @param mixed $outputTitle
     *
     * @dataProvider getTestGetTitleData()
     */
    public function testGetTitle($inputTitle, $outputTitle)
    {
        $comment = new Comment();
        $comment->setTitle($inputTitle);
        $this->assertEquals(
            $outputTitle,
            $comment->getTitle()
        );
    }

    /**
     * @return array
     */
    public function getTestGetBodyData()
    {
        return [
            ['Geras būrelis', 'Geras būrelis'],
        ];
    }

    /**
     * @param mixed $inputBody
     * @param mixed $outputBody
     *
     * @dataProvider getTestGetBodyData()
     */
    public function testGetBody($inputBody, $outputBody)
    {
        $comment = new Comment();
        $comment->setBody($inputBody);
        $this->assertEquals(
            $outputBody,
            $comment->getBody()
        );
    }

    /**
     * @return array
     */
    public function getTestGetNameData()
    {
        return [
            ['Rimas', 'Rimas'],
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
        $comment = new Comment();
        $comment->setName($inputName);
        $this->assertEquals(
            $outputName,
            $comment->getName()
        );
    }

    /**
     * @return array
     */
    public function getTestGetEmailData()
    {
        return [
            ['rimas@gmail.com', 'rimas@gmail.com'],
        ];
    }

    /**
     * @param mixed $inputEmail
     * @param mixed $outputEmail
     *
     * @dataProvider getTestGetEmailData()
     */
    public function testGetEmail($inputEmail, $outputEmail)
    {
        $comment = new Comment();
        $comment->setEmail($inputEmail);
        $this->assertEquals(
            $outputEmail,
            $comment->getEmail()
        );
    }

    /**
     * @return array
     */
    public function getTestGetRateData()
    {
        return [
            [5, 5],
            [2, 2],
        ];
    }

    /**
     * @param int $inputRate
     * @param int $outputRate
     *
     * @dataProvider getTestGetRateData()
     */
    public function testGetRate($inputRate, $outputRate)
    {
        $comment = new Comment();
        $comment->setRate($inputRate);
        $this->assertEquals(
            $outputRate,
            $comment->getRate()
        );
    }
}
