<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Offer
 *
 * @ORM\Table(name="offer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OfferRepository")
 */
class Offer
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Activity", inversedBy="offers")
     * @ORM\JoinColumn(name="activity_id", referencedColumnName="id")
     */
    protected $activity;

    /**
     * @ORM\ManyToOne(targetEntity="Trainer", inversedBy="offers")
     * @ORM\JoinColumn(name="trainer_id", referencedColumnName="id")
     */
    protected $trainer;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="childrenAgeFrom", type="integer")
     */
    private $childrenAgeFrom;

    /**
     * @var int
     *
     * @ORM\Column(name="childrenAgeTo", type="integer")
     */
    private $childrenAgeTo;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=45)
     */
    private $address;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Offer
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set childrenAgeFrom
     *
     * @param integer $childrenAgeFrom
     *
     * @return Offer
     */
    public function setChildrenAgeFrom($childrenAgeFrom)
    {
        $this->childrenAgeFrom = $childrenAgeFrom;

        return $this;
    }

    /**
     * Get childrenAgeFrom
     *
     * @return int
     */
    public function getChildrenAgeFrom()
    {
        return $this->childrenAgeFrom;
    }

    /**
     * Set childrenAgeTo
     *
     * @param integer $childrenAgeTo
     *
     * @return Offer
     */
    public function setChildrenAgeTo($childrenAgeTo)
    {
        $this->childrenAgeTo = $childrenAgeTo;

        return $this;
    }

    /**
     * Get childrenAgeTo
     *
     * @return int
     */
    public function getChildrenAgeTo()
    {
        return $this->childrenAgeTo;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Offer
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set activity
     *
     * @param \AppBundle\Entity\Activity $activity
     *
     * @return Offer
     */
    public function setActivity(\AppBundle\Entity\Activity $activity = null)
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * Get activity
     *
     * @return \AppBundle\Entity\Activity
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * Set trainer
     *
     * @param \AppBundle\Entity\Trainer $trainer
     *
     * @return Offer
     */
    public function setTrainer(\AppBundle\Entity\Trainer $trainer = null)
    {
        $this->trainer = $trainer;

        return $this;
    }

    /**
     * Get trainer
     *
     * @return \AppBundle\Entity\Trainer
     */
    public function getTrainer()
    {
        return $this->trainer;
    }
}
