<?php

namespace AppBundle\Controller;

use AppBundle\Entity\OfferSearch;
use AppBundle\Form\CommentType;
use AppBundle\Repository\ActivityRepository;
use AppBundle\Repository\OfferRepository;
use AppBundle\Entity\Offer;
use AppBundle\Entity\Comment;
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
        $offer = new OfferSearch();
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
     * @param OfferSearch $offer
     *
     * @return Response
     */
    public function searchAction(OfferSearch $offer = null)
    {
        if ($offer === null) {
            $offer = new Offer();
        }

        /** @var OfferRepository $offerRepository */
        $offerRepository = $this->getDoctrine()->getRepository('AppBundle:Offer');

        return $this->render('AppBundle:Home:search.html.twig', [
            'offers' => $offerRepository->search($offer),
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
     * @param Request $request
     * @param int     $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function offerDetailsAction(Request $request, $id)
    {

        $offerRepository = $this->getDoctrine()->getRepository('AppBundle:Offer');
        $offer = $offerRepository->find($id);
        if (empty($offer)) {
            return $this->redirect($this->generateUrl('app.search'));
        }
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $comment->setOffer($offer);
            $manager->persist($comment);
            $manager->flush();

            return $this->render('AppBundle:Home:offerDetails.html.twig', [
                'form' => $form->createView(),
                'comments' => $offer->getComments(),
                'offer' => $offer,
                'similarOffers' => $offerRepository->searchSimilarOffers($offer),
            ]);
        }

        return $this->render('AppBundle:Home:offerDetails.html.twig', [
            'form' => $form->createView(),
            'comments' => $offer->getComments(),
            'offer' => $offer,
            'similarOffers' => $offerRepository->searchSimilarOffers($offer),
        ]);
    }
}
