<?php

namespace AppBundle\Utility;

use AppBundle\Entity\Activity;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Offer;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Symfony\Component\Form\FormError;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class DataManager
{
    /**
     * @var Registry
     */
    private $doctrine;

    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * DataManager constructor.
     * @param Registry $doctrine
     * @param TokenStorage $tokenStorage
     */
    public function __construct($doctrine, $tokenStorage)
    {
        $this->doctrine = $doctrine;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param Offer $offer
     * @param $user
     */
    public function createOffer($offer, $user)
    {
        $offer->setUser($user);
        $entityManager = $this->doctrine->getManager();
        if ($offer->getMainImage()) {
            $entityManager->persist($offer->getMainImage());
        }
        if ($offer->getImages() && $offer->getImages()[0]) {
            foreach ($offer->getImages() as $image) {
                $image->setOffer($offer);
            }
        }
        $entityManager->persist($offer);
        $entityManager->flush();
    }

    /**
     * @param $form
     * @return array
     */
    public function getFormErrors($form)
    {
        $errors = [
            'ages' => false,
            'gender' => false,
        ];
        foreach ($form->getErrors() as $error) {
            /** @var FormError $error */
            if ($parameters = $error->getMessageParameters()) {
                if (isset($parameters['id'])) {
                    $errors[$parameters['id']] = $error->getMessage();
                }
            }
        }
        return $errors;
    }

    /**
     * @param Offer $offer
     * @param Comment $comment
     */
    public function createComment($offer, $comment)
    {
        $entityManager = $this->doctrine->getManager();
        $comment->setOffer($offer);
        $entityManager->persist($comment);
        $offer->addComment($comment);
        $entityManager->persist($offer);
        $entityManager->flush();
    }

    /**
     * @param Activity $activity
     */
    public function createActivity($activity)
    {
        $entityManager = $this->doctrine->getEntityManager();
        if ($activity->getDefaultImage()) {
            $entityManager->persist($activity->getDefaultImage());
        }
        $entityManager->persist($activity);
        $entityManager->flush();
    }

    /**
     * @param Activity $oldActivity
     * @param Activity $newActivity
     * @return boolean
     */
    public function editActivity($oldActivity, $newActivity)
    {
        if ($newActivity->getName() !== $oldActivity->getName() ||
            $newActivity->getDefaultImage()
        ) {
            $entityManager = $this->doctrine->getEntityManager();
            if ($newActivity->getDefaultImage()) {
                $entityManager->persist($newActivity->getDefaultImage());
            } else {
                $newActivity->setDefaultImage($oldActivity->getDefaultImage());
            }
            $entityManager->persist($newActivity);
            $entityManager->flush();
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param Offer $offer
     */
    public function deleteOffer($offer)
    {
        $entityManager = $this->doctrine->getManager();
        $entityManager->remove($offer);
        $entityManager->flush();
    }
}
