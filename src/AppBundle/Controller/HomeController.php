<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Activity;
use AppBundle\Entity\OfferSearch;
use AppBundle\Repository\ActivityRepository;
use AppBundle\Repository\OfferImageRepository;
use AppBundle\Repository\OfferRepository;
use AppBundle\Form\IndexSearchOffer;
use AppBundle\Form\OfferType;
use AppBundle\Entity\Offer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * Class HomeController
 * @package AppBundle\Controller
 */
class HomeController extends Controller
{
    /**
     * Home page index action.
     *
     * @Template("AppBundle:Home:index.html.twig")
     * @return array
     */
    public function indexAction()
    {
        $form = $this->createForm(IndexSearchOffer::class, null, [
            'action' => $this->generateUrl('app.search'),
            'method' => 'GET',
        ]);
        
        /** @var ActivityRepository $activityRepository */
        $activityRepository = $this->getDoctrine()->getRepository('AppBundle:Activity');

        return [
            'form' => $form->createView(),
            'activities' => $activityRepository->getActivityList(),
        ];
    }

    /**
     * Offer search action
     *
     * @Template("AppBundle:Home:search.html.twig")
     * @param Request $request
     * @return array
     */
    public function searchAction(Request $request)
    {
        $offer = new OfferSearch();
        $form = $this->createForm(IndexSearchOffer::class, $offer);

        $form->handleRequest($request);

        /** @var ActivityRepository $activityRepository */
        $activityRepository = $this->getDoctrine()->getRepository('AppBundle:Activity');

        /** @var OfferRepository $offerRepository */
        $offerRepository = $this->getDoctrine()->getRepository('AppBundle:Offer');

        $offers = $offerRepository->search($offer);

        return [
            'activities' => $activityRepository->getActivityList(),
            'age_list' => $offerRepository->getAgeList(),
            'offers' => $offers,
            'offers_json' => $offerRepository->prepareJSON($offers),
            'form' => $form->createView(),
        ];
    }

    /**
     * Offer and account registration action.
     *
     * @param Request $request
     * @return Response
     */
    public function coachesAction(Request $request)
    {
        $loggedIn = $this->container->get('security.authorization_checker')
            ->isGranted('IS_AUTHENTICATED_FULLY');
        $offer = new Offer();
        $form = $this->createForm(OfferType::class, $offer);

        // If the user is logged in, don't show account creation fields
        if ($loggedIn) {
            $form->remove('user');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // If user creates an account when registering an offer, we pass
            // the offer being created and the user information to the
            // user registration action, and then we persist the
            // offer being created.
            $response = null;
            if (!$loggedIn) {
                $userFields = $request->request->get('offer')['user'];
                $userFields['_token'] = $request->request->get('_registration_token');
                $request->request->set('_internal', true);
                $request->request->set(
                    'fos_user_registration_form',
                    $userFields
                );
                $response = $this->forward(
                    'FOSUserBundle:Registration:register',
                    ['offer' => $offer]
                );
                // Remove the default FOSUserBundle account registration success
                // flash message.
                $this->get('session')->getFlashBag()->clear();
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($offer->getMainImage());
            $em->persist($offer);
            $em->flush();
            // Unset the form so that the fields do not get repopulated
            unset($offer);
            unset($form);
            $offer = new Offer();
            $form = $this->createForm(OfferType::class, $offer);
            if (!$loggedIn && $response && $response->getContent() === 'Ok') {
                $this->addFlash('success', 'Jūsų paskyra sukurta, o būrelis patalpintas į sistemą');
                return $this->redirect($this->generateUrl('fos_user_profile_edit'));
            }
            $form->remove('user');
            $this->addFlash('success', 'Jūsų būrelis patalpintas į sistemą');
        }

        // Checking if class level assertions failed and setting variables
        // for the template to render error classes on invalid fields.
        $errors = [
            'ages' => false,
            'gender' => false,
        ];
        foreach ($form->getErrors() as $error) {
            if ($parameters = $error->getMessageParameters()) {
                if (isset($parameters['id'])) {
                    $errors[$parameters['id']] = $error->getMessage();
                }
            }
        }

        return $this->render('AppBundle:Home:coaches.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors,
        ]);
    }

    /**
     * Individual offer details action.
     *
     * @Template("AppBundle:Home:offerDetails.html.twig")
     * @param Offer $offer
     * @return Response
     */
    public function offerDetailsAction(Offer $offer)
    {
        $offerRepository = $this->getDoctrine()->getRepository('AppBundle:Offer');

        if (empty($offer)) {
            return $this->redirect($this->generateUrl('app.search'));
        }

        return [
            'offer' => $offer,
            'similarOffers' => $offerRepository->searchSimilarOffers($offer),
        ];
    }
    
    /**
     * Users registered offers action.
     *
     * @Template("AppBundle:Home:offers.html.twig")
     * @Security("has_role('ROLE_USER')")
     * @return array
     */
    public function offersAction()
    {
        $offerRepository = $this->getDoctrine()->getRepository('AppBundle:Offer');
        $offers = $offerRepository->getUsersOffers($this->getUser());

        return  [
            'offers' => $offers,
        ];
    }

    /**
     * Offer import action.
     *
     * @Template("AppBundle:Home:offerImport.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $request
     * @return array
     */
    public function offerImportAction(Request $request)
    {
        if ($file = $request->files->get('fileInput')) {
            if (($handle = fopen($file->getRealPath(), "r")) !== false) {
                $entityManager = $this->getDoctrine()->getManager();
                /** @var ActivityRepository $activityRepository */
                $activityRepository = $this->getDoctrine()->getRepository('AppBundle:Activity');
                /** @var OfferImageRepository $imageRepository */
                $imageRepository = $this->getDoctrine()->getRepository('AppBundle:OfferImage');
                $images = $imageRepository->getImages();
                $offers = [];
                $activities = [];
                while (($data = fgetcsv($handle, null, "|")) !== false) {
                    $offer = new Offer();
                    $offer->setImported(true);
                    $offer->setName($data[0]);
                    $offer->setDescription($data[1]);
                    $offer->setLatitude($data[2]);
                    $offer->setLongitude($data[3]);
                    $offer->setPrice($data[4]);
                    $offer->setPaymentType($data[5]);
                    if ($activity = $activityRepository->findBy(['name' => $data[6]])) {
                        /** @var Activity[] $activity */
                        $offer->setActivity($activity[0]);
                        $offer->setMainImage($activity[0]->getDefaultImage());
                    } else {
                        $activity = new Activity();
                        $activity->setName($data[6]);
                        $entityManager->persist($activity);
                        $activities[] = $activity;
                        $offer->setActivity($activity);
                        $offer->setMainImage($images[0]);
                    }
                    $offer->setContactInfo(
                        $data[7] . ' ' . $data[8] . ' - ' . $data[9]
                    );
                    $offer->setMale($data[10] == '1' ? true : false);
                    $offer->setFemale($data[11] == '1' ? true : false);
                    $offer->setAgeFrom($data[12]);
                    $offer->setAgeTo($data[13]);
                    $offer->setAddress($data[14]);
                    $offers[] = $offer;
                    $entityManager->persist($offer);
                }
                $entityManager->flush();
                fclose($handle);
            }
        }
    }
}
