<?php

namespace AppBundle\Repository;

use AppBundle\Entity\OfferSearch;
use AppBundle\Entity\User;
use \Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Offer;

/**
 * OfferRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OfferRepository extends EntityRepository
{
    /**
     * @param OfferSearch $offer
     * @return mixed
     */
    public function search(OfferSearch $offer)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        if ($offer->getLatitude() && $offer->getLongitude()) {
            $qb->select("o," .
                "(6371 * ACOS(" .
                "COS(RADIANS({$offer->getLatitude()})) * " .
                "COS(RADIANS(o.latitude)) * " .
                "COS(RADIANS(o.longitude) - RADIANS({$offer->getLongitude()})) + " .
                "SIN(RADIANS({$offer->getLatitude()})) * SIN(RADIANS(o.latitude)))" .
                ") as distance")
                ->from('AppBundle:Offer', 'o')
                ->orderBy('distance');
            if ($offer->getDistance()) {
                $qb->having('distance <= :radius')
                    ->setParameter('radius', $offer->getDistance());
            }
        } else {
            $qb->select("o")
                ->from('AppBundle:Offer', 'o');
        }

        if ($offer->getAge()) {
            $qb->where("o.ageFrom <= {$offer->getAge()}")
                ->andWhere("o.ageTo >= {$offer->getAge()}");
        }

        if ($offer->isFemale()) {
            $qb->where("o.female = true");
        }

        if ($offer->isMale()) {
            $qb->where("o.male = true");
        }

        $results = $qb->getQuery()->execute();

        if ($offer->getLatitude() && $offer->getLongitude()) {
            $returnArray = [];
            foreach ($results as $result) {
                $result[0]->setDistance($result['distance']);
                $returnArray[] = $result[0];
            }
            return $returnArray;
        }

        return $results;
    }

    /**
     * @param Offer $offer
     * @return mixed
     */
    public function searchSimilarOffers(Offer $offer)
    {
        $activity = $offer->getActivity()->getName();
        $ageFrom = $offer->getAgeFrom();
        $ageTo = $offer->getAgeTo();
        $address = $offer->getAddress();

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('o')
            ->from('AppBundle:Offer', 'o');

        if ($activity) {
            $qb->leftJoin('o.activity', 'a');
            $qb->orWhere('a.name = :activity')
                ->setParameter('activity', $activity);
        }

        if ($address) {
            $qb->orWhere('o.address = :address')
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

    /**
     * Generates possible age list
     * @return array
     */
    public function getAgeList()
    {
        $list = [];

        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('o.ageFrom')
            ->from('AppBundle:Offer', 'o')
            ->orderBy('o.ageFrom', 'ASC');
        $first = $qb->getQuery()->setMaxResults(1)->execute();

        $qb2 = $this->getEntityManager()->createQueryBuilder();
        $qb2->select('u.ageTo')
            ->from('AppBundle:Offer', 'u')
            ->orderBy('u.ageTo', 'DESC');
        $last = $qb2->getQuery()->setMaxResults(1)->execute();

        for ($i=$first[0]['ageFrom']; $i<=$last[0]['ageTo']; $i++) {
            array_push($list, $i);
        }

        return $list;
    }

    /**
     * @param $offers
     * @return JSON
     */
    public function prepareJSON($offers)
    {
        $data = [];
        foreach ($offers as $offer) {
            $data[$offer->getId()]['id'] = $offer->getId();
            $data[$offer->getId()]['activity'] = $offer->getActivity()->getName();
            $data[$offer->getId()]['name'] = $offer->getName();
            $data[$offer->getId()]['description'] = $offer->getDescription();
            $data[$offer->getId()]['price'] = $offer->getPrice();
            $data[$offer->getId()]['address'] = $offer->getAddress();
            $data[$offer->getId()]['latitude'] = $offer->getLatitude();
            $data[$offer->getId()]['longitude'] = $offer->getLongitude();
            $data[$offer->getId()]['image'] = $offer->getImage();
        }

        return json_encode($data);
    }

    /**
     * @param User $user
     * @return Offer[]
     */
    public function getUsersOffers(User $user)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('o')
            ->from('AppBundle:Offer', 'o');

        $qb->where('o.user = :user')->setParameter('user', $user);

        return $qb->getQuery()->execute();
    }
}
