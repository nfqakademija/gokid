<?php

namespace AppBundle\Controller;

use AppBundle\Repository\ActivityRepository;
use AppBundle\Repository\OfferRepository;
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
        /** @var ActivityRepository $activityRepository */
        $activityRepository = $this->getDoctrine()->getRepository('AppBundle:Activity');

        return $this->render('AppBundle:Home:index.html.twig', array(
            'activities' => $activityRepository->getActivityList(),
        ));
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function searchAction(Request $request)
    {
        /** @var OfferRepository $offerRepository */
        $offerRepository = $this->getDoctrine()->getRepository('AppBundle:Offer');

        return $this->render('AppBundle:Home:search.html.twig', [
            'offers' => $offerRepository->search($request),
        ]);
    }

    /**
     * User login action.
     *
     * @return Response
     */
    public function loginAction()
    {
        return $this->render('AppBundle:Home:login.html.twig', []);
    }

    /**
     * Coach info action.
     *
     * @return Response
     */
    public function coachesAction()
    {
        return $this->render('AppBundle:Home:coaches.html.twig', []);
    }
}
