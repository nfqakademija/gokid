<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Validator\Constraints as CustomAssert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Index;

/**
 * Offer
 *
 * @ORM\Table(
 *     name="offers",
 *     options={"engine":"MyISAM"},
 *     indexes={@Index(name="position_index", columns={"latitude", "longitude"})}
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OfferRepository")
 * @CustomAssert\GenderSelected
 * @CustomAssert\AgesAscending
 */
class Offer
{
    // Payment type constants
    const SINGLE_TIME = 0;
    const WEEKLY = 1;
    const MONTHLY = 2;

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
     * @ORM\JoinColumn(name="activity_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     * @Assert\NotNull(message="Prašome pasirinkti būrelio sporto šaką")
     */
    private $activity;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="offers")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * @Assert\Valid
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
     * @ORM\Column(columnDefinition="TINYINT DEFAULT 1 NOT NULL")
     */
    private $paymentType;

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
     * @Assert\Range(
     *     min=0,
     *     max=18,
     *     minMessage="Amžius negali būti neigiamas",
     *     maxMessage="Maksimalus apatinis amžių rėžis yra 18 metų"
     * )
     */
    private $ageFrom;

    /**
     * @var int
     *
     * @ORM\Column(name="age_to", type="integer")
     * @Assert\NotBlank(message="Prašome įvesti didžiausią galimą vaiko amžių")
     * @Assert\Range(
     *     min=0,
     *     minMessage="Amžius negali būti neigiamas"
     * )
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
     * @ORM\Column(name="rating", type="float", nullable=true)
     */
    protected $rating;

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
     * @CustomAssert\ImageSizes(maxSize="1048576").
     * @CustomAssert\ImageExtensions(extensions={"jpg","png","gif"})
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\OfferImage")
     * @ORM\JoinColumn(name="main_image_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     * @CustomAssert\ImageSizes(maxSize="1048576")
     * @CustomAssert\ImageExtensions(extensions={"jpg","png","gif"})
     */
    private $mainImage;

    /**
     * @var float
     */
    private $distance;

    /**
     * @var boolean
     *
     * @ORM\Column(name="imported", type="boolean")
     */
    private $imported = false;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_info", type="string", length=120)
     */
    private $contactInfo = "";

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="offer")
     */
    protected $comments;

    /**
     * Activity constructor.
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

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
     * @return float
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param float $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
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


    /**
     * @return mixed
     */
    public function getMainImage()
    {
        return $this->mainImage;
    }

    /**
     * @param OfferImage $mainImage
     */
    public function setMainImage($mainImage)
    {
        $this->mainImage = $mainImage;
    }

    /**
     * @return mixed
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * @param mixed $paymentType
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;
    }

    /**
     * @return string
     */
    public function getContactInfo()
    {
        return $this->contactInfo;
    }

    /**
     * @param string $contactInfo
     */
    public function setContactInfo($contactInfo)
    {
        if ($contactInfo == null) {
            $contactInfo = "";
        }
        $this->contactInfo = $contactInfo;
    }

    /**
     * @return boolean
     */
    public function isImported()
    {
        return $this->imported;
    }

    /**
     * @param boolean $imported
     */
    public function setImported($imported)
    {
        $this->imported = $imported;
    }

    /**
     * Add comment
     *
     * @param Comment $comment
     *
     * @return Offer
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;

        $rating = $this->getRating();
        $count = count($this->getComments());

        $this->setRating(($rating * ($count - 1) + $comment->getRate()) / $count);

        return $this;
    }

    /**
     * Remove comment
     *
     * @param Comment $comment
     */
    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return ArrayCollection
     */
    public function getComments()
    {
        return $this->comments;
    }
}
