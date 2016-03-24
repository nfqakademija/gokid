<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
        return $this->render('AppBundle:Home:index.html.twig', []);
    }

    /**
     * User login action.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction()
    {
        return $this->render('AppBundle:Home:login.html.twig', []);
    }

    /**
     * Coach info action.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function coachesAction()
    {
        return $this->render('AppBundle:Home:coaches.html.twig', []);
    }
}
