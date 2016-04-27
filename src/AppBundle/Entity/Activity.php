<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Activity
 *
 * @ORM\Table(name="activities")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ActivityRepository")
 */
class Activity
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45)
     * @Assert\NotBlank(message="Prašome įvesti sporto šakos pavadinimą")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Offer", mappedBy="activity")
     */
    private $offers;


    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\OfferImage")
     * @ORM\JoinColumn(name="default_image_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     * @Assert\NotBlank(message="Prašome įkelti numatytają sporto šakos nuotrauką")
     */
    private $defaultImage;

    /**
     * @return OfferImage
     */
    public function getDefaultImage()
    {
        return $this->defaultImage;
    }

    /**
     * @param OfferImage $defaultImage
     */
    public function setDefaultImage($defaultImage)
    {
        $this->defaultImage = $defaultImage;
    }

    /**
     * Activity constructor.
     */
    public function __construct()
    {
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
     * @return Activity
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
     * Add offer
     *
     * @param Offer $offer
     *
     * @return Activity
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

    /**
     * Converts activity to string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
