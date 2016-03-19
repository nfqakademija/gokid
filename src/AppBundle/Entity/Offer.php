<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Activity;
use AppBundle\Entity\User;

/**
 * Offer
 *
 * @ORM\Table(name="offers")
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="offers")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

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
    public function setActivity(Activity $activity = null)
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
     * Set user
     *
     * @param User $user
     *
     * @return Offer
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
