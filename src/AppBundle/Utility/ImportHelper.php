<?php

namespace AppBundle\Utility;

use AppBundle\Entity\Offer;
use AppBundle\Entity\Activity;
use AppBundle\Entity\OfferImage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Helper class for importing offers from a csv file.
 *
 * Class ImportHelper
 * @package AppBundle\Utility
 */
class ImportHelper
{
    /**
     * @param String $filepath
     * @return null|array
     */
    public function parseCsv($filepath)
    {
        $i = 0;
        if (($handle = fopen($filepath, "r")) !== false) {
            $offers = [];
            $offerImages = [];
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
                if (isset($data[15])) {
                    $offerImage = $this->createOfferImageFromFile(
                        $data[15],
                        $i++
                    );
                    $offer->setMainImage($offerImage);
                    $offerImage->setOffer($offer);
                    $index = 16;
                    while (isset($data[$index])) {
                        $offerImage = $this->createOfferImageFromFile(
                            $data[$index],
                            $i++
                        );
                        $offerImage->setOffer($offer);
                        $index++;
                        $offerImages[] = $offerImage;
                    }
                }
                $offers[] = $offer;
            }
            fclose($handle);
            return [
                'offers' => $offers,
                'offerImages' => $offerImages
            ];
        }
        return null;
    }

    /**
     * @param string $fileUrl
     * @param string $tmpFileIndex
     * @return OfferImage|null
     */
    public function createOfferImageFromFile($fileUrl, $tmpFileIndex)
    {
        $extension = $this->getFileExtension($fileUrl);
        $path = 'images/tmpImages/tmp' . $tmpFileIndex . '.' . $extension;
        if ($image = $this->downloadImage($fileUrl, $path)) {
            $offerImage = new OfferImage();
            $offerImage->setImageFile($image);
            return $offerImage;
        }
        return null;
    }

    /**
     * @param $filename
     * @return string
     */
    public function getFileExtension($filename)
    {
        $extension = explode('.', $filename);
        $extension = $extension[sizeof($extension) - 1];
        return $extension;
    }

    /**
     * @param string $path
     * @param string $name
     * @return null|UploadedFile
     */
    public function downloadImage($path, $name)
    {
        $ch = curl_init($path);
        $fp = fopen($name, 'a+');
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($httpCode == 200) {
            curl_setopt($ch, CURLOPT_NOBODY, false);
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $fileType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
            $file = new UploadedFile(
                $name,
                $path,
                $fileType,
                filesize($name),
                null,
                true
            );
            return $file;
        } else {
            return null;
        }
    }
}
