<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=120)
     */
    private $name = '';

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=45)
     */
    protected $phone = '';

    /**
     * @var int
     *
     * @ORM\Column(name="rating", type="integer", nullable=true)
     */
    protected $rating;

    /**
     * @ORM\OneToMany(targetEntity="Offer", mappedBy="user")
     */
    protected $offers;

    /**
     * @var string
     */
    protected $currentPassword;

    /**
     * @return mixed
     */
    public function getCurrentPassword()
    {
        return $this->currentPassword;
    }

    /**
     * @param mixed $currentPassword
     */
    public function setCurrentPassword($currentPassword)
    {
        $this->currentPassword = $currentPassword;
    }

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->offers = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return User
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
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set rating
     *
     * @param integer $rating
     *
     * @return User
     */
    public function setRating($rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * Get rating
     *
     * @return int
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * Username can not be null. Set email as username if it is empty.
     *
     * {@inheritDoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;

        if ($this->username === null) {
            $this->setUsername($email);
        }

        return $this;
    }

    /**
     * Add offer
     *
     * @param Offer $offer
     *
     * @return User
     */
    public function addOffer(Offer $offer)
    {
        $this->offers[] = $offer;

        return $this;
    }

    /**
     * Remove offer
     *
     * @param Offer $offer
     */
    public function removeOffer(Offer $offer)
    {
        $this->offers->removeElement($offer);
    }

    /**
     * Get offers
     *
     * @return ArrayCollection
     */
    public function getOffers()
    {
        return $this->offers;
    }
}
