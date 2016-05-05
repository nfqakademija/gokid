<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Activity;
use AppBundle\Entity\OfferImage;
use AppBundle\Entity\OfferSearch;
use AppBundle\Form\ActivityType;
use AppBundle\Form\CommentType;
use AppBundle\Form\ActivityTypeMapped;
use AppBundle\Repository\ActivityRepository;
use AppBundle\Repository\OfferRepository;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Offer;
use AppBundle\Form\IndexSearchOffer;
use AppBundle\Form\OfferType;
use AppBundle\Utility\ImportHelper;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Csrf\CsrfToken;

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

        if ($request->query->get('activity')
        ) {
            $offer->setActivity($request->query->get('activity'));
        }

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
        $offer = new Offer();
        $form = $this->createForm(OfferType::class, $offer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $offer->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($offer->getMainImage());
            $em->persist($offer);
            $em->flush();
            // Unset the form so that the fields do not get repopulated
            unset($form);
            $form = $this->createForm(OfferType::class, new Offer());
            $this->addFlash('success', 'Jūsų būrelis patalpintas į sistemą');
        }

        // Checking if class level assertions failed and setting variables
        // for the template to render error classes on invalid fields.
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

        return $this->render('AppBundle:Home:coaches.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors,
        ]);
    }

    /**
     * Individual offer details action.
     *
     * @param Request $request
     * @param Offer $offer
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Template("AppBundle:Home:offerDetails.html.twig")
     */
    public function offerDetailsAction(Request $request, Offer $offer)
    {
        /** @var OfferRepository $offerRepository */
        $offerRepository = $this->getDoctrine()->getRepository('AppBundle:Offer');

        if (empty($offer)) {
            return $this->redirect($this->generateUrl('app.search'));
        }

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $comment->setOffer($offer);
            $em->persist($comment);
            $offer->addComment($comment);
            $em->persist($offer);

            $em->flush();

            return $this->redirect(
                $this->generateUrl('app.offerDetails', [
                    'id'=>$offer->getId()
                ]) . '#'.$comment->getId()
            );
        }

        return [
            'form' => $form->createView(),
            'comments' => $offer->getComments(),
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
    public function offersAction(Request $request)
    {
        $paginator = $this->get('knp_paginator');
        /** @var OfferRepository $offerRepository */
        $offerRepository = $this->getDoctrine()->getRepository('AppBundle:Offer');
        $offers = $offerRepository->getUsersOffers(
            $this->getUser(),
            $paginator,
            $request
        );

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
        $form = $this->createForm(ActivityTypeMapped::class, $activity, [
            'validation_groups' => ['creation', 'Default']
        ]);
        /** @var ActivityRepository $activityRepository */
        $activityRepository = $this->getDoctrine()->getRepository('AppBundle:Activity');

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $defaultImage = new OfferImage();
            /** @var UploadedFile $imageFile */
            $imageFile = $activity->getDefaultImage();
            $defaultImage->setImageFile($imageFile);
            $activity->setDefaultImage($defaultImage);
            $entityManager = $this->getDoctrine()->getEntityManager();
            $entityManager->persist($activity->getDefaultImage());
            $entityManager->persist($activity);
            $entityManager->flush();
            $this->addFlash('success', 'Sporto šaka sukurta');
            unset($activity);
        }

        $paginator = $this->get('knp_paginator');

        return [
            'activities' => $activityRepository->getAllActivitiesPaginated(
                $paginator,
                $request
            ),
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

    /**
     * Offer delete action.
     *
     * @Template("AppBundle:Home:offerDeleteConfirmation.html.twig")
     * @param Request $request
     * @param Offer $offer
     * @return array|RedirectResponse
     */
    public function offerDeleteAction(Request $request, Offer $offer)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $tokenManager = $this->get('security.csrf.token_manager');
        if ($request->request->get('_csrf_token')) {
            $token = new CsrfToken(
                'offer_delete',
                $request->request->get('_csrf_token')
            );
            if ($tokenManager->isTokenValid($token)
                && $offer->getUser() == $user
                && $request->request->get('answer') === 'y'
            ) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($offer);
                $entityManager->flush();
                $this->addFlash('success', 'Būrelis ištrintas');
                return $this->redirect(
                    $this->generateUrl('app.registeredOffers')
                );
            } elseif ($request->request->get('answer') === 'n') {
                return $this->redirect(
                    $this->generateUrl('app.registeredOffers')
                );
            }
        }

        return [
            'offer' => $offer,
        ];
    }
}
