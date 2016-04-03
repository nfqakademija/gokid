<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        return $this->render('AppBundle:Home:index.html.twig', []);
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

    /**
     * @return Response
     */
    public function offerDetailsAction($id)
    {
        $offerRepository = $this->getDoctrine()->getRepository('AppBundle:Offer');
        $offer = $offerRepository->find($id);

        return $this->render('AppBundle:Home:offerDetails.html.twig', [
            'offer' => $offer,
            'similarOffers' => $offerRepository->searchSimilarOffers($offer),
        ]);
    }
}
