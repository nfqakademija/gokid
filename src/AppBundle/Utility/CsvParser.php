<?php

namespace AppBundle\Utility;

use AppBundle\Entity\Offer;
use AppBundle\Entity\Activity;

class CsvParser
{
    /**
     * @param String $filepath
     * @return Offer[]
     */
    public function parseCsv($filepath)
    {
        if (($handle = fopen($filepath, "r")) !== false) {
            $offers = [];
            while (($data = fgetcsv($handle, null, "|")) !== false) {
                $offer = new Offer();
                $offer->setImported(true);
                $offer->setName($data[0]);
                $offer->setDescription($data[1]);
                $offer->setLatitude($data[2]);
                $offer->setLongitude($data[3]);
                $offer->setPrice($data[4]);
                $offer->setPaymentType($data[5]);
                $activity = new Activity();
                $activity->setName($data[6]);
                $offer->setActivity($activity);
                $offer->setContactInfo(
                    $data[7] . ' ' . $data[8] . ' - ' . $data[9]
                );
                $offer->setMale($data[10] == '1' ? true : false);
                $offer->setFemale($data[11] == '1' ? true : false);
                $offer->setAgeFrom($data[12]);
                $offer->setAgeTo($data[13]);
                $offer->setAddress($data[14]);
                $offers[] = $offer;
            }
            fclose($handle);
            return $offers;
        }
    }
}
