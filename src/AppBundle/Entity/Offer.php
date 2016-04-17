<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as CustomAssert;

/**
 * Offer
 *
 * @ORM\Table(name="offers")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OfferRepository")
 * @CustomAssert\GenderSelected
 * @CustomAssert\AgesAscending
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
     * @Assert\NotNull(message="Prašome pasirinkti būrelio sporto šaką")
     */
    private $activity;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="offers")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=120)
     * @Assert\NotBlank(message="Prašome įvesti būrelio pavadinimą")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank(message="Prašome įvesti būrelio aprašymą")
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer")
     * @Assert\NotBlank(message="Prašome įvesti būrelio kainą")
     */
    private $price;

    /**
     * @var boolean
     *
     * @ORM\Column(name="male", type="boolean")
     */
    private $male;

    /**
     * @var boolean
     *
     * @ORM\Column(name="female", type="boolean")
     */
    private $female;

    /**
     * @var int
     *
     * @ORM\Column(name="age_from", type="integer")
     * @Assert\NotBlank(message="Prašome įvesti mažiausią galimą vaiko amžių")
     */
    private $ageFrom;

    /**
     * @var int
     *
     * @ORM\Column(name="age_to", type="integer")
     * @Assert\NotBlank(message="Prašome įvesti didžiausią galimą vaiko amžių")
     */
    private $ageTo;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=45)
     * @Assert\NotBlank(message="Prašome įvesti būrelio vykimo vietą")
     */
    private $address;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float")
     */
    private $latitude;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float")
     */
    private $longitude;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\OfferImage", mappedBy="offer", cascade={"persist"})
     */
    private $images;

    /**
     * @var float
     */
    private $distance;

    /**
     * @return mixed
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * @param mixed $distance
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Offer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Offer
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set ageFrom
     *
     * @param integer $ageFrom
     *
     * @return Offer
     */
    public function setAgeFrom($ageFrom)
    {
        $this->ageFrom = $ageFrom;

        return $this;
    }

    /**
     * Get ageFrom
     *
     * @return int
     */
    public function getAgeFrom()
    {
        return $this->ageFrom;
    }

    /**
     * Set ageTo
     *
     * @param integer $ageTo
     *
     * @return Offer
     */
    public function setAgeTo($ageTo)
    {
        $this->ageTo = $ageTo;

        return $this;
    }

    /**
     * Get ageTo
     *
     * @return int
     */
    public function getAgeTo()
    {
        return $this->ageTo;
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
     * @param Activity $activity
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
     * @return Activity
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

    /**
     * Set male
     *
     * @param boolean $male
     *
     * @return Offer
     */
    public function setMale($male)
    {
        $this->male = $male;

        return $this;
    }

    /**
     * Is male
     *
     * @return boolean
     */
    public function isMale()
    {
        return $this->male;
    }

    /**
     * Set female
     *
     * @param boolean $female
     *
     * @return Offer
     */
    public function setFemale($female)
    {
        $this->female = $female;

        return $this;
    }

    /**
     * Is female
     *
     * @return boolean
     */
    public function isFemale()
    {
        return $this->female;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     *
     * @return Offer
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     *
     * @return Offer
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set image
     *
     * @param OfferImage[] $images
     *
     * @return Offer
     */
    public function setImages($images)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return OfferImage[]
     */
    public function getImages()
    {
        return $this->images;
    }
}
