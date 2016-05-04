<?php

namespace AppBundle\Utility;

use AppBundle\Entity\Offer;
use AppBundle\Entity\Activity;
use AppBundle\Entity\OfferImage;
use AppBundle\Repository\ActivityRepository;
use AppBundle\Utility\Curl\CurlRequest;
use ProxyManager\Proxy\Exception\RemoteObjectException;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Helper class for importing offers from a csv file.
 *
 * Class ImportHelper
 * @package AppBundle\Utility
 */
class ImportHelper
{
    /**
     * @var ManagerRegistry
     */
    private $managerRegistry;

    /**
     * @var ActivityRepository
     */
    private $activityRepo;

    /**
     * @var TokenStorage
     */
    private $tokenStorage;

    /**
     * ImportHelper constructor.
     *
     * @param ManagerRegistry $manager
     */
    public function __construct(
        ManagerRegistry $manager,
        TokenStorage $tokenStorage
    ) {
        $this->managerRegistry = $manager;
        $this->tokenStorage = $tokenStorage;
        $this->activityRepo = $manager->getRepository('AppBundle:Activity');
    }

    /**
     * @param String $filepath
     * @return null|array
     */
    public function parseCsv($filepath)
    {
        $i = 0;
        if (file_exists($filepath) && ($handle = fopen($filepath, "r")) !== false) {
            $offers = [];
            $offerImages = [];
            while (($data = fgetcsv($handle, null, "|", "~")) !== false) {
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
                $offer->setMale($data[8] == '1' ? true : false);
                $offer->setFemale($data[9] == '1' ? true : false);
                $offer->setAgeFrom($data[10]);
                $offer->setAgeTo($data[11]);
                $offer->setAddress($data[12]);
                if (isset($data[13]) && $data[13] != "") {
                    if (!($offerImage = $this->createOfferImageFromFile(
                        $data[13],
                        $i++
                    ))) {
                        throw new RemoteObjectException(
                            'Paveikslėlio parsiųsti iš ' . $data[13] . ' nepavyko'
                        );
                    };
                    $offer->setMainImage($offerImage);
                    $offerImage->setOffer($offer);
                    $index = 14;
                    while (isset($data[$index]) && $data[$index] != "") {
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
                'offerImages' => $offerImages,
            ];
        }

        throw new FileNotFoundException($filepath);
    }

    /**
     * @param array $data
     */
    public function import($data)
    {
        $user = $this->tokenStorage->getToken()->getUser();
        $entityManager = $this->managerRegistry->getManager();
        /** @var Offer $offer */
        foreach ($data['offers'] as $offer) {
            /** @var Activity[] $activity */
            if ($activity = $this->activityRepo->findBy(
                ['name' => $offer->getActivity()->getName()]
            )) {
                $offer->setActivity($activity[0]);
                if (!$offer->getMainImage()) {
                    $offer->setMainImage($activity[0]->getDefaultImage());
                }
            } else {
                $entityManager->persist($offer->getActivity());
            }
            $offer->setUser($user);
            $entityManager->persist($offer);
            if ($offer->getMainImage()) {
                $entityManager->persist($offer->getMainImage());
            }
        }
        foreach ($data['offerImages'] as $image) {
            $entityManager->persist($image);
        }
        $entityManager->flush();
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
        $curl = new CurlRequest($fileUrl);
        if ($image = $this->downloadImage($curl, $fileUrl, $path)) {
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
     * @param CurlRequest $curl
     * @param string $path
     * @param string $name
     * @return null|UploadedFile
     */
    public function downloadImage($curl, $path, $name)
    {
        $fp = fopen($name, 'a+');
        $curl->setOption(CURLOPT_NOBODY, true);
        $curl->execute();
        $httpCode = $curl->getInfo(CURLINFO_HTTP_CODE);
        if ($httpCode == 200) {
            $curl->setOption(CURLOPT_NOBODY, false);
            $curl->setOption(CURLOPT_FILE, $fp);
            $curl->setOption(CURLOPT_HEADER, 0);
            $curl->setOption(CURLOPT_RETURNTRANSFER, 1);
            $fileType = $curl->getInfo(CURLINFO_CONTENT_TYPE);
            $curl->execute();
            $curl->close();
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
