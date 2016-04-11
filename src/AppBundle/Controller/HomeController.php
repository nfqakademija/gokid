<?php

namespace AppBundle\Controller;

use AppBundle\Repository\ActivityRepository;
use AppBundle\Entity\Offer;
use AppBundle\Form\IndexSearchOffer;
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
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $offer = new Offer();
        $form = $this->createForm(IndexSearchOffer::class, $offer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->forward('AppBundle:Home:search', ['offer' => $offer]);
        }

        /** @var ActivityRepository $activityRepository */
        $activityRepository = $this->getDoctrine()->getRepository('AppBundle:Activity');

        return $this->render('AppBundle:Home:index.html.twig', [
            'form' => $form->createView(),
            'activities' => $activityRepository->getActivityList(),
        ]);
    }

    /**
     * @param Offer|null $offer
     * @return Response
     */
    public function searchAction(Offer $offer = null)
    {
        if ($offer === null) {
            $offer = new Offer();
        }
        $search = $this->get('app.searchService');

        return $this->render('AppBundle:Home:search.html.twig', [
            'offers' => $search->findByAddress($offer),
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

    /**
     * @param int $id
     * @return Response
     */
    public function offerDetailsAction($id)
    {
        $search = $this->get('app.searchService');
        $offer = $search->findById($id);
        if (empty($offer)) {
            return $this->redirect($this->generateUrl('app.search'));
        }

        return $this->render('AppBundle:Home:offerDetails.html.twig', [
            'offer' => $offer,
            'similarOffers' => $search->findSimilarOffers($offer),
        ]);
    }
}
