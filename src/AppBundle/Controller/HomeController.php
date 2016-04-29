<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Activity;
use AppBundle\Entity\OfferImage;
use AppBundle\Entity\OfferSearch;
use AppBundle\Form\ActivityType;
use AppBundle\Repository\ActivityRepository;
use AppBundle\Repository\OfferRepository;
use AppBundle\Form\IndexSearchOffer;
use AppBundle\Form\OfferType;
use AppBundle\Entity\Offer;
use AppBundle\Utility\ImportHelper;
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

        /** @var OfferRepository $offerRepository */
        $offerRepository = $this->getDoctrine()->getRepository('AppBundle:Offer');

        return [
            'form' => $form->createView(),
            'activities' => $activityRepository->getActivityList(),
            'age_list' => $offerRepository->getAgeList(),
            'offer_count' => $offerRepository->getOfferCount(),
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

        $paginator   = $this->get('knp_paginator');

        $offers      = $offerRepository->search($offer, $paginator, $request);
        $offersJson  = $offerRepository->prepareJSON($offers->getItems());

        if ($request->get('ajax') == 1) {
            $offers->setParam('ajax', null);

            return $this->render('AppBundle:Home/includes:offerObjects.html.twig', [
                'ajax' => 1,
                'offers' => $offers,
                'offers_json' => $offersJson,
            ]);
        }

        return [
            'activities' => $activityRepository->getAllActivities(),
            'age_list' => $offerRepository->getAgeList(),
            'offers' => $offers,
            'offers_json' => $offersJson,
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
            /** @var ImportHelper $importer */
            $importer = $this->get('import_helper');

            try {
                $data = $importer->parseCsv($file->getRealPath());
                $importer->import($data);
                $this->addFlash('success', 'Būreliai sėkmingai įkelti');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Įvyko klaida:' . $e->getMessage());
            }
        }
    }

    /**
     * Activity creation action.
     *
     * @Template("AppBundle:Home:activityCreate.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     * @return array
     */
    public function activityCreateAction(Request $request)
    {
        $activity = new Activity();
        $form = $this->createForm(ActivityType::class, $activity, [
            'validation_groups' => ['creation', 'Default']
        ]);
        /** @var ActivityRepository $activityRepository */
        $activityRepository = $this->getDoctrine()->getRepository('AppBundle:Activity');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $defaultImage = new OfferImage();
            $defaultImage->setImageFile($activity->getDefaultImage());
            $activity->setDefaultImage($defaultImage);
            $entityManager = $this->getDoctrine()->getEntityManager();
            $entityManager->persist($activity->getDefaultImage());
            $entityManager->persist($activity);
            $entityManager->flush();
            $this->addFlash('success', 'Sporto šaka sukurta');
            unset($activity);
        }

        return [
            'activities' => $activityRepository->getAllActivities(),
            'form' => $form->createView(),
        ];
    }

    /**
     * Activity edit action.
     *
     * @Template("AppBundle:Home:activityEdit.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     * @return array
     */
    public function activityEditAction(Request $request, Activity $activity)
    {
        $form = $this->createForm(ActivityType::class, $activity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getEntityManager();
            if (isset($request->files->get('activity')['defaultImage'])) {
                $entityManager->remove($activity->getDefaultImage());
                $defaultImage = new OfferImage();
                $defaultImage->setImageFile(
                    $request->files->get('activity')['defaultImage']
                );
                $entityManager->persist($defaultImage);
                $activity->setDefaultImage($defaultImage);
            }
            $entityManager->persist($activity);
            $entityManager->flush();
            $this->addFlash('success', 'Sporto šaka atnaujinta');

            return $this->redirect($this->generateUrl('app.activityCreate'));
        }

        return [
            'form' => $form->createView(),
        ];
    }
}
