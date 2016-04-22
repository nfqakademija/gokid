<?php

namespace AppBundle\Controller;

use AppBundle\Entity\OfferSearch;
use AppBundle\Repository\ActivityRepository;
use AppBundle\Repository\OfferRepository;
use AppBundle\Form\IndexSearchOffer;
use AppBundle\Form\OfferType;
use AppBundle\Entity\Offer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HomeController
 * @package AppBundle\Controller
 */
class HomeController extends Controller
{
    /**
     * Home page index action.
     *
     * @return Response
     */
    public function indexAction()
    {
        $form = $this->createForm(IndexSearchOffer::class, null, [
            'action' => $this->generateUrl('app.search'),
            'method' => 'GET',
        ]);
        
        /** @var ActivityRepository $activityRepository */
        $activityRepository = $this->getDoctrine()->getRepository('AppBundle:Activity');

        return $this->render('AppBundle:Home:index.html.twig', [
            'form' => $form->createView(),
            'activities' => $activityRepository->getActivityList(),
        ]);
    }

    /**
     * @param Request $request
     * @return Response
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

        return $this->render('AppBundle:Home:search.html.twig', [
            'activities' => $activityRepository->getActivityList(),
            'age_list' => $offerRepository->getAgeList(),
            'offers' => $offers,
            'offers_json' => $offerRepository->prepareJSON($offers),
        ]);
    }

    /**
     * Coach info action.
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
            $em->persist($offer);
            $em->flush();
            unset($offer);
            unset($form);
            $offer = new Offer();
            $form = $this->createForm(OfferType::class, $offer);
            if (!$loggedIn && $response && $response->getContent() === 'Ok') {
                $this->addFlash('success', 'Jūsų paskyra sukurta, o būrelis patalpintas į sistemą');
                return $this->redirect($this->generateUrl('fos_user_profile_edit'));
            } else {
                $this->addFlash('success', 'Jūsų būrelis patalpintas į sistemą');
            }
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
     * @param int $id
     * @return Response
     */
    public function offerDetailsAction($id)
    {
        $offerRepository = $this->getDoctrine()->getRepository('AppBundle:Offer');
        $offer = $offerRepository->find($id);

        if (empty($offer)) {
            return $this->redirect($this->generateUrl('app.search'));
        }

        return $this->render('AppBundle:Home:offerDetails.html.twig', [
            'offer' => $offer,
            'similarOffers' => $offerRepository->searchSimilarOffers($offer),
        ]);
    }
    
    /**
     * @return Response
     */
    public function offersAction()
    {
        $offerRepository = $this->getDoctrine()->getRepository('AppBundle:Offer');
        $offers = $offerRepository->getUsersOffers($this->getUser());

        return $this->render('AppBundle:Home:offers.html.twig', [
            'offers' => $offers,
        ]);
    }
}
