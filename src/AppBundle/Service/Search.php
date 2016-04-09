<?php
/**
 * Created by PhpStorm.
 * User: rimas
 * Date: 4/8/16
 * Time: 6:33 PM
 */

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Offer;

/**
 * Class Search
 * @package AppBundle\Service
 */
class Search
{
    protected $em;

    /**
     * Search constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param Offer $offer
     * @return mixed
     */
    public function findByAddress(Offer $offer)
    {
        $address = $offer->getAddress();
        $qb = $this->em->createQueryBuilder();
        $qb->select('o')
            ->from('AppBundle:Offer', 'o');
        if ($address) {
            $qb->Where('o.address = :address')
                ->setParameter('address', $address);
        }

        return $qb->getQuery()->execute();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id)
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('o')
            ->from('AppBundle:Offer', 'o');
        if ($id) {
            $qb->Where('o.id = :id')
                ->setParameter('id', $id);
        }

        return $qb->getQuery()->execute();
    }

    /**
     * @param Offer $offer
     * @return mixed
     */
    public function findSimilarOffers(Offer $offer)
    {
        $activity = $offer->getActivity()->getName();
        $ageFrom = $offer->getAgeFrom();
        $ageTo = $offer->getAgeTo();
        $address = $offer->getAddress();

        $qb = $this->em->createQueryBuilder();
        $qb->select('o')
            ->from('AppBundle:Offer', 'o');

        if ($activity) {
            $qb->leftJoin('o.activity', 'a');
            $qb->Where('a.name = :activity')
                ->setParameter('activity', $activity);
        }

        if ($address) {
            $qb->andWhere('o.address = :address')
                ->setParameter('address', $address);
        }

        if ($ageFrom) {
            $qb->orWhere('o.ageFrom = :ageFrom')
                ->setParameter('ageFrom', $ageFrom);
        }

        if ($ageTo) {
            $qb->orWhere('o.ageTo = :ageTo')
                ->setParameter('ageTo', $ageTo);
        }

        return $qb->getQuery()->setMaxResults(4)->execute();
    }
}
