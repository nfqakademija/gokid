<?php

namespace AppBundle\Controller;

use AppBundle\Repository\OfferRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class HomeController
 * @package AppBundle\Controller
 */
class HomeController extends Controller
{
    /**
     * Home page index action.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Home:index.html.twig', array());
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction(Request $request)
    {
//        var_dump(get_loaded_extensions());die();
        /** @var OfferRepository $offerRepository */
        $offerRepository = $this->getDoctrine()->getRepository('AppBundle:Offer');

        return $this->render('AppBundle:Home:search.html.twig', [
            'offers' => $offerRepository->search($request),
            'modules' => get_loaded_extensions(),
        ]);
    }
}
